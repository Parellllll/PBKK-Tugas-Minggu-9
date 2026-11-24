<?php

namespace App\Controllers\Admin;

use App\Models\DosenModel;
use App\Models\ProdiModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class DosenController extends BaseAdminController
{
    public function index(): string
    {
        return $this->renderView('admin/master/dosen', [
            'title' => 'Master Data Dosen',
            'dosen' => (new DosenModel())->getAllWithRelasi(),
            'prodi' => (new ProdiModel())->findAll(),
        ]);
    }

    public function create(): string
    {
        return $this->renderView('admin/master/dosen_form', [
            'title' => 'Tambah Dosen Baru',
            'prodi' => (new ProdiModel())->findAll(),
        ]);
    }

    public function store(): RedirectResponse
    {
        $rules = [
            'username' => 'required|alpha_dash|min_length[3]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'nidn'     => 'required|numeric|is_unique[dosen.nidn]',
            'nama'     => 'required|min_length[3]',
            'prodi_id' => 'required|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = db_connect();
        $db->transStart();

        $userModel = new UserModel();
        $userId    = $userModel->insert([
            'username'      => trim((string) $this->request->getPost('username')),
            'nama_lengkap'  => trim((string) $this->request->getPost('nama')),
            'email'         => trim((string) $this->request->getPost('email')),
            'password_hash' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'          => 'dosen',
        ]);

        (new DosenModel())->insert([
            'user_id'        => $userId,
            'prodi_id'       => (int) $this->request->getPost('prodi_id'),
            'nidn'           => trim((string) $this->request->getPost('nidn')),
            'nama'           => trim((string) $this->request->getPost('nama')),
            'gelar_depan'    => trim((string) $this->request->getPost('gelar_depan')),
            'gelar_belakang' => trim((string) $this->request->getPost('gelar_belakang')),
            'email'          => trim((string) $this->request->getPost('email')),
        ]);

        $db->transComplete();

        if (! $db->transStatus()) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data dosen.');
        }

        return redirect()->to('/admin/master/dosen')->with('success', 'Data dosen & akun login berhasil dibuat.');
    }

    public function delete(int $id): RedirectResponse
    {
        $dosen = (new DosenModel())->find($id);
        if (! $dosen) {
            return redirect()->to('/admin/master/dosen')->with('error', 'Data dosen tidak ditemukan.');
        }

        try {
            (new UserModel())->delete($dosen['user_id']);
            return redirect()->to('/admin/master/dosen')->with('success', 'Data dosen berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->to('/admin/master/dosen')->with('error', 'Dosen tidak dapat dihapus karena masih mengampu kelas aktif.');
        }
    }
}

