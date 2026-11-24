<?php

namespace App\Controllers\Admin;

use App\Models\TahunAkademikModel;
use CodeIgniter\HTTP\RedirectResponse;

class TahunAkademikController extends BaseAdminController
{
    public function index(): string
    {
        return $this->renderView('admin/master/tahun_akademik', [
            'title' => 'Master Tahun Akademik',
            'items' => (new TahunAkademikModel())->orderBy('kode', 'DESC')->findAll(),
        ]);
    }

    public function store(): RedirectResponse
    {
        $model = new TahunAkademikModel();
        $data  = [
            'kode'     => trim((string) $this->request->getPost('kode')),
            'nama'     => trim((string) $this->request->getPost('nama')),
            'semester' => (string) $this->request->getPost('semester'),
            'is_aktif' => 0,
        ];

        if (! $model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to('/admin/master/tahun-akademik')->with('success', 'Tahun akademik baru berhasil ditambahkan.');
    }

    public function aktifkan(int $id): RedirectResponse
    {
        (new TahunAkademikModel())->aktifkan($id);

        return redirect()->to('/admin/master/tahun-akademik')->with('success', 'Tahun akademik aktif berhasil diperbarui.');
    }
}

