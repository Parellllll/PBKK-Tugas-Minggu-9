<?php

namespace App\Controllers\Admin;

use App\Models\MahasiswaModel;
use App\Models\ProdiModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class MahasiswaController extends BaseAdminController
{
    public function index(): string
    {
        $keyword = $this->request->getGet('q');

        return $this->renderView('admin/master/mahasiswa', [
            'title'     => 'Master Data Mahasiswa',
            'mahasiswa' => (new MahasiswaModel())->getAllWithRelasi($keyword),
            'keyword'   => $keyword ?? '',
        ]);
    }

    public function create(): string
    {
        return $this->renderView('admin/master/mahasiswa_form', [
            'title' => 'Tambah Mahasiswa Baru',
            'prodi' => (new ProdiModel())->findAll(),
        ]);
    }

    public function store(): RedirectResponse
    {
        $rules = [
            'username' => 'required|alpha_dash|min_length[3]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'nrp'      => 'required|numeric|min_length[8]|is_unique[mahasiswa.nrp]',
            'nama'     => 'required|min_length[3]',
            'prodi_id' => 'required|integer',
            'angkatan' => 'required|integer|greater_than_equal_to[2018]|less_than_equal_to[2030]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = db_connect();
        $db->transStart();

        $userId = (new UserModel())->insert([
            'username'      => trim((string) $this->request->getPost('username')),
            'nama_lengkap'  => trim((string) $this->request->getPost('nama')),
            'email'         => trim((string) $this->request->getPost('email')),
            'password_hash' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'          => 'mahasiswa',
        ]);

        (new MahasiswaModel())->insert([
            'user_id'  => $userId,
            'prodi_id' => (int) $this->request->getPost('prodi_id'),
            'nrp'      => trim((string) $this->request->getPost('nrp')),
            'nama'     => trim((string) $this->request->getPost('nama')),
            'angkatan' => (int) $this->request->getPost('angkatan'),
            'status'   => 'aktif',
        ]);

        $db->transComplete();

        if (! $db->transStatus()) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data mahasiswa.');
        }

        return redirect()->to('/admin/master/mahasiswa')->with('success', 'Data mahasiswa & akun login berhasil dibuat.');
    }

    public function delete(int $id): RedirectResponse
    {
        $mhs = (new MahasiswaModel())->find($id);
        if (! $mhs) {
            return redirect()->to('/admin/master/mahasiswa')->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        (new UserModel())->delete($mhs['user_id']);

        return redirect()->to('/admin/master/mahasiswa')->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}

