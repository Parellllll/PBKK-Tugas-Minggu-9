<?php

namespace App\Services;

use App\Exceptions\EmptyCartException;
use App\Exceptions\InsufficientStockException;
use App\Libraries\CartLibrary;
use App\Models\DetailPesananModel;
use App\Models\PesananModel;
use App\Models\ProdukModel;
use Config\Toko;

class CheckoutService
{
    public function __construct(
        private readonly CartLibrary $cart,
        private readonly Toko $config
    ) {
    }

    /**
     * Memproses checkout dalam transaksi database atomik.
     * Jika salah satu produk stoknya kurang, seluruh pengurangan stok di-rollback.
     *
     * @throws EmptyCartException
     * @throws InsufficientStockException
     *
     * @return array{pesanan_id: int, kode_invoice: string, total: int}
     */
    public function prosesCheckout(int $userId, array $pengiriman): array
    {
        $items = $this->cart->items();
        if (empty($items)) {
            throw new EmptyCartException();
        }

        $db           = db_connect();
        $produkModel  = new ProdukModel();
        $pesananModel = new PesananModel();
        $detailModel  = new DetailPesananModel();

        $db->transBegin();

        try {
            $subtotal       = 0;
            $preparedDetail = [];

            foreach ($items as $item) {
                $produk = $produkModel->find((int) $item['produk_id']);
                $qty    = (int) $item['qty'];

                if (! $produk || (int) $produk['is_aktif'] !== 1) {
                    throw new InsufficientStockException($item['nama'], 0, $qty);
                }

                $stokAktual = (int) $produk['stok'];
                if ($stokAktual < $qty) {
                    throw new InsufficientStockException($produk['nama'], $stokAktual, $qty);
                }

                // Kurangi stok secara atomik di dalam transaksi
                $db->table('produk')
                    ->where('id', (int) $produk['id'])
                    ->set('stok', 'stok - ' . $qty, false)
                    ->update();

                $hargaSatuan = (int) $produk['harga'];
                $lineTotal   = $hargaSatuan * $qty;
                $subtotal   += $lineTotal;

                $preparedDetail[] = [
                    'produk_id'            => (int) $produk['id'],
                    'nama_produk_snapshot' => $produk['nama'],
                    'harga_satuan'         => $hargaSatuan,
                    'qty'                  => $qty,
                    'subtotal'             => $lineTotal,
                ];
            }

            $ongkir      = $subtotal >= $this->config->gratisOngkirMinimal ? 0 : $this->config->ongkirFlat;
            $total       = $subtotal + $ongkir;
            $kodeInvoice = 'INV-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));

            $pesananId = (int) $pesananModel->insert([
                'kode_invoice'      => $kodeInvoice,
                'user_id'           => $userId,
                'nama_penerima'     => trim((string) $pengiriman['nama_penerima']),
                'no_hp'             => trim((string) $pengiriman['no_hp']),
                'alamat_pengiriman' => trim((string) $pengiriman['alamat_pengiriman']),
                'metode_pembayaran' => (string) $pengiriman['metode_pembayaran'],
                'ongkir'            => $ongkir,
                'subtotal'          => $subtotal,
                'total'             => $total,
                'status'            => 'pending',
                'catatan'           => trim((string) ($pengiriman['catatan'] ?? '')),
            ]);

            foreach ($preparedDetail as &$detail) {
                $detail['pesanan_id'] = $pesananId;
            }
            unset($detail);

            $detailModel->insertBatch($preparedDetail);

            if ($db->transStatus() === false) {
                $db->transRollback();
                throw new \RuntimeException('Transaksi database gagal disimpan.');
            }

            $db->transCommit();
            $this->cart->clear();

            return [
                'pesanan_id'   => $pesananId,
                'kode_invoice' => $kodeInvoice,
                'total'        => $total,
            ];
        } catch (\Throwable $e) {
            $db->transRollback();
            throw $e;
        }
    }

    /**
     * Mengubah status pesanan; jika dibatalkan dari status aktif, stok dikembalikan secara atomik.
     */
    public function ubahStatusPesanan(int $pesananId, string $statusBaru): bool
    {
        $pesananModel = new PesananModel();
        $detailModel  = new DetailPesananModel();
        $pesanan      = $pesananModel->find($pesananId);

        if (! $pesanan || ! array_key_exists($statusBaru, $this->config->daftarStatus)) {
            return false;
        }

        $db = db_connect();
        $db->transBegin();

        try {
            $statusLama = $pesanan['status'];

            // Kembalikan stok jika pesanan dibatalkan
            if ($statusLama !== 'dibatalkan' && $statusBaru === 'dibatalkan') {
                $details = $detailModel->where('pesanan_id', $pesananId)->findAll();
                foreach ($details as $d) {
                    $db->table('produk')
                        ->where('id', (int) $d['produk_id'])
                        ->set('stok', 'stok + ' . ((int) $d['qty']), false)
                        ->update();
                }
            }

            $pesananModel->update($pesananId, ['status' => $statusBaru]);
            $db->transCommit();

            return true;
        } catch (\Throwable $e) {
            $db->transRollback();
            return false;
        }
    }
}

