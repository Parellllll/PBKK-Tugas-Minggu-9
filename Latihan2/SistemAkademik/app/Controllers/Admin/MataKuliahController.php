<?php

namespace App\Controllers\Admin;

use App\Models\MataKuliahModel;
use App\Models\ProdiModel;
use CodeIgniter\HTTP\RedirectResponse;

class MataKuliahController extends BaseAdminController
{
    public function index(): string
    {
        return $this->renderView('admin/master/matakuliah', [
            'title'      => 'Master Mata Kuliah',
            'matakuliah' => (new MataKuliahModel())->getAllWithProdi(),
            'prodi'      => (new ProdiModel())->findAll(),
        ]);
    }

    public function store(): RedirectResponse
    {
        $model = new MataKuliahModel();
        $data  = [
            'prodi_id'       => (int) $this->request->getPost('prodi_id'),
            'kode'           => strtoupper(trim((string) $this->request->getPost('kode'))),
            'nama'           => trim((string) $this->request->getPost('nama')),
            'sks'            => (int) $this->request->getPost('sks'),
            'semester_paket' => (int) $this->request->getPost('semester_paket'),
        ];

        if (! $model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to('/admin/master/matakuliah')->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    public function delete(int $id): RedirectResponse
    {
        (new MataKuliahModel())->delete($id);

        return redirect()->to('/admin/master/matakuliah')->with('success', 'Mata kuliah berhasil dihapus.');
    }
}

