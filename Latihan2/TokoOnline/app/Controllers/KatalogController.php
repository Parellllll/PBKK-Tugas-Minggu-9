<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use App\Models\ProdukModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class KatalogController extends BaseController
{
    public function index(): string
    {
        $produkModel   = new ProdukModel();
        $kategoriModel = new KategoriModel();

        $filters = [
            'q'         => (string) ($this->request->getGet('q') ?? ''),
            'kategori'  => (string) ($this->request->getGet('kategori') ?? ''),
            'min_harga' => (string) ($this->request->getGet('min_harga') ?? ''),
            'max_harga' => (string) ($this->request->getGet('max_harga') ?? ''),
            'sort'      => (string) ($this->request->getGet('sort') ?? 'terbaru'),
        ];

        return view('store/katalog', [
            'title'    => 'TokoKita — Katalog Produk Online',
            'produk'   => $produkModel->filterKatalog($filters, 8, true),
            'pager'    => $produkModel->pager,
            'kategori' => $kategoriModel->getAllWithJumlahProduk(),
            'filters'  => $filters,
        ]);
    }

    public function detail(string $slug): string
    {
        $produkModel = new ProdukModel();
        $produk      = $produkModel->findBySlug($slug);

        if (! $produk || (int) $produk['is_aktif'] !== 1) {
            throw PageNotFoundException::forPageNotFound('Produk tidak ditemukan.');
        }

        $terkait = $produkModel->select('produk.*, kategori.nama AS nama_kategori')
            ->join('kategori', 'kategori.id = produk.kategori_id')
            ->where('produk.kategori_id', $produk['kategori_id'])
            ->where('produk.id !=', $produk['id'])
            ->where('produk.is_aktif', 1)
            ->findAll(4);

        return view('store/detail', [
            'title'   => $produk['nama'] . ' — TokoKita',
            'produk'  => $produk,
            'terkait' => $terkait,
        ]);
    }
}

