<?php

namespace App\Libraries;

use CodeIgniter\Session\Session;
use Config\Toko;

class CartLibrary
{
    private const SESSION_KEY = 'tokokita_cart';

    public function __construct(
        private readonly Session $session,
        private readonly Toko $config
    ) {
    }

    /**
     * @return array<int, array{produk_id: int, kode: string, nama: string, slug: string, harga: int, qty: int, stok: int, gambar: ?string}>
     */
    public function items(): array
    {
        return (array) ($this->session->get(self::SESSION_KEY) ?? []);
    }

    public function add(array $produk, int $qty = 1): void
    {
        $qty  = max(1, $qty);
        $cart = $this->items();
        $id   = (int) $produk['id'];

        if (isset($cart[$id])) {
            $cart[$id]['qty']  += $qty;
            $cart[$id]['harga'] = (int) $produk['harga'];
            $cart[$id]['stok']  = (int) $produk['stok'];
        } else {
            $cart[$id] = [
                'produk_id' => $id,
                'kode'      => (string) $produk['kode'],
                'nama'      => (string) $produk['nama'],
                'slug'      => (string) $produk['slug'],
                'harga'     => (int) $produk['harga'],
                'qty'       => $qty,
                'stok'      => (int) $produk['stok'],
                'gambar'    => $produk['gambar'] ?? null,
            ];
        }

        $this->session->set(self::SESSION_KEY, $cart);
    }

    public function updateQty(int $produkId, int $qty): void
    {
        $cart = $this->items();
        if (! isset($cart[$produkId])) {
            return;
        }

        if ($qty <= 0) {
            unset($cart[$produkId]);
        } else {
            $cart[$produkId]['qty'] = $qty;
        }

        $this->session->set(self::SESSION_KEY, $cart);
    }

    public function remove(int $produkId): void
    {
        $cart = $this->items();
        unset($cart[$produkId]);
        $this->session->set(self::SESSION_KEY, $cart);
    }

    public function clear(): void
    {
        $this->session->remove(self::SESSION_KEY);
    }

    public function isEmpty(): bool
    {
        return empty($this->items());
    }

    public function totalQty(): int
    {
        return array_sum(array_column($this->items(), 'qty'));
    }

    public function subtotal(): int
    {
        $sum = 0;
        foreach ($this->items() as $item) {
            $sum += ((int) $item['harga']) * ((int) $item['qty']);
        }

        return $sum;
    }

    public function ongkir(): int
    {
        if ($this->isEmpty()) {
            return 0;
        }

        return $this->subtotal() >= $this->config->gratisOngkirMinimal ? 0 : $this->config->ongkirFlat;
    }

    public function grandTotal(): int
    {
        return $this->subtotal() + $this->ongkir();
    }
}

