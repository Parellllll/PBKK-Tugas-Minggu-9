<?php

namespace App\Controllers\Admin;

use App\Models\ProdiModel;
use CodeIgniter\HTTP\RedirectResponse;

class ProdiController extends BaseAdminController
{
    public function index(): string
    {
        return $this->renderView('admin/master/prodi', [
            'title' => 'Master Program Studi',
            'prodi' => (new ProdiModel())->orderBy('kode', 'ASC')->findAll(),
        ]);
    }

    public function store(): RedirectResponse
    {
        $model = new ProdiModel();
        $data  = [
            'kode'     => strtoupper(trim((string) $this->request->getPost('kode'))),
            'nama'     => trim((string) $this->request->getPost('nama')),
            'fakultas' => trim((string) $this->request->getPost('fakultas')),
            'jenjang'  => (string) $this->request->getPost('jenjang'),
        ];

        if (! $model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to('/admin/master/prodi')->with('success', 'Program studi berhasil ditambahkan.');
    }

    public function delete(int $id): RedirectResponse
    {
        try {
            (new ProdiModel())->delete($id);
            return redirect()->to('/admin/master/prodi')->with('success', 'Program studi berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->to('/admin/master/prodi')->with('error', 'Prodi tidak dapat dihapus karena masih digunakan oleh data dosen/mahasiswa/mata kuliah.');
        }
    }
}

