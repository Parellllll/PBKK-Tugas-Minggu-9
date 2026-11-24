<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DetailPesananModel;
use App\Models\PesananModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;
use Config\Toko;

class PesananController extends BaseController
{
    public function index(): string
    {
        $status = $this->request->getGet('status');

        return view('admin/pesanan/index', [
            'title'       => 'Manajemen Pesanan',
            'pesanan'     => (new PesananModel())->getAllWithCustomer($status),
            'statusAktif' => $status ?? '',
            'tokoConfig'  => config(Toko::class),
        ]);
    }

    public function detail(string $invoice): string
    {
        $pesanan = (new PesananModel())->findByInvoice($invoice);
        if (! $pesanan) {
            throw PageNotFoundException::forPageNotFound('Pesanan tidak ditemukan.');
        }

        return view('admin/pesanan/detail', [
            'title'      => 'Detail Pesanan ' . $pesanan['kode_invoice'],
            'pesanan'    => $pesanan,
            'items'      => (new DetailPesananModel())->getByPesananId((int) $pesanan['id']),
            'tokoConfig' => config(Toko::class),
        ]);
    }

    public function ubahStatus(int $id): RedirectResponse
    {
        $statusBaru = (string) $this->request->getPost('status');
        $berhasil   = Services::checkout()->ubahStatusPesanan($id, $statusBaru);

        if (! $berhasil) {
            return redirect()->back()->with('error', 'Gagal memperbarui status pesanan.');
        }

        $pesan = $statusBaru === 'dibatalkan'
            ? 'Pesanan dibatalkan dan stok produk telah dikembalikan secara otomatis.'
            : 'Status pesanan berhasil diubah menjadi ' . label_status_pesanan($statusBaru) . '.';

        return redirect()->back()->with('success', $pesan);
    }
}

