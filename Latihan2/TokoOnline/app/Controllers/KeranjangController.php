<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;
use Config\Toko;

class KeranjangController extends BaseController
{
    public function index(): string
    {
        $cart = Services::cart();

        return view('store/keranjang', [
            'title'      => 'Keranjang Belanja — TokoKita',
            'items'      => $cart->items(),
            'subtotal'   => $cart->subtotal(),
            'ongkir'     => $cart->ongkir(),
            'grandTotal' => $cart->grandTotal(),
            'tokoConfig' => config(Toko::class),
        ]);
    }

    public function tambah(): RedirectResponse
    {
        $produkId = (int) $this->request->getPost('produk_id');
        $qty      = max(1, (int) $this->request->getPost('qty', FILTER_VALIDATE_INT) ?: 1);

        $produk = (new ProdukModel())->find($produkId);
        if (! $produk || (int) $produk['is_aktif'] !== 1) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan atau tidak aktif.');
        }

        if ((int) $produk['stok'] < 1) {
            return redirect()->back()->with('error', 'Stok produk "' . $produk['nama'] . '" sedang habis.');
        }

        Services::cart()->add($produk, $qty);

        return redirect()->back()->with('success', '"' . $produk['nama'] . '" (' . $qty . 'x) ditambahkan ke keranjang.');
    }

    public function ubah(): RedirectResponse
    {
        $produkId = (int) $this->request->getPost('produk_id');
        $qty      = (int) $this->request->getPost('qty');

        Services::cart()->updateQty($produkId, $qty);

        return redirect()->to('/keranjang')->with('success', 'Jumlah keranjang berhasil diperbarui.');
    }

    public function hapus(int $produkId): RedirectResponse
    {
        Services::cart()->remove($produkId);

        return redirect()->to('/keranjang')->with('success', 'Item dihapus dari keranjang.');
    }

    public function kosongkan(): RedirectResponse
    {
        Services::cart()->clear();

        return redirect()->to('/keranjang')->with('success', 'Keranjang belanja telah dikosongkan.');
    }
}

