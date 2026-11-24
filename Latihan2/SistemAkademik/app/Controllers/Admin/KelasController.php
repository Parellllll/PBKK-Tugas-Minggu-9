<?php

namespace App\Controllers\Admin;

use App\Models\DosenModel;
use App\Models\KelasModel;
use App\Models\MataKuliahModel;
use App\Models\TahunAkademikModel;
use CodeIgniter\HTTP\RedirectResponse;

class KelasController extends BaseAdminController
{
    public function index(): string
    {
        return $this->renderView('admin/master/kelas', [
            'title'         => 'Master Kelas & Jadwal Kuliah',
            'kelas'         => (new KelasModel())->getDaftarKelas(),
            'matakuliah'    => (new MataKuliahModel())->getAllWithProdi(),
            'dosen'         => (new DosenModel())->getAllWithRelasi(),
            'tahunAkademik' => (new TahunAkademikModel())->orderBy('kode', 'DESC')->findAll(),
        ]);
    }

    public function store(): RedirectResponse
    {
        $model = new KelasModel();
        $data  = [
            'mata_kuliah_id'    => (int) $this->request->getPost('mata_kuliah_id'),
            'dosen_id'          => (int) $this->request->getPost('dosen_id'),
            'tahun_akademik_id' => (int) $this->request->getPost('tahun_akademik_id'),
            'nama_kelas'        => strtoupper(trim((string) $this->request->getPost('nama_kelas'))),
            'jadwal'            => trim((string) $this->request->getPost('jadwal')),
            'ruangan'           => trim((string) $this->request->getPost('ruangan')),
            'kuota'             => (int) $this->request->getPost('kuota'),
        ];

        if (! $model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to('/admin/master/kelas')->with('success', 'Kelas perkuliahan baru berhasil dibuka.');
    }

    public function delete(int $id): RedirectResponse
    {
        (new KelasModel())->delete($id);

        return redirect()->to('/admin/master/kelas')->with('success', 'Kelas berhasil dihapus.');
    }
}

