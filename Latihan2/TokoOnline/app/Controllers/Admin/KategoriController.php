<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriModel;
use CodeIgniter\HTTP\RedirectResponse;

class KategoriController extends BaseController
{
    public function index(): string
    {
        return view('admin/kategori/index', [
            'title'    => 'Kelola Kategori Produk',
            'kategori' => (new KategoriModel())->getAllWithJumlahProduk(),
        ]);
    }

    public function store(): RedirectResponse
    {
        $nama  = trim((string) $this->request->getPost('nama'));
        $model = new KategoriModel();

        $data = [
            'nama'      => $nama,
            'slug'      => slugify_text($nama),
            'deskripsi' => trim((string) $this->request->getPost('deskripsi')),
        ];

        if (! $model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to('/admin/kategori')->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function delete(int $id): RedirectResponse
    {
        try {
            (new KategoriModel())->delete($id);
            return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->to('/admin/kategori')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk.');
        }
    }
}

