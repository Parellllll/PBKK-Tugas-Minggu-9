<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class UserController extends BaseController
{
    public function index(): string
    {
        $userModel = new UserModel();

        return view('admin/users/index', [
            'title' => 'Manajemen Akses User',
            'users' => $userModel->orderBy('id', 'ASC')->findAll(),
        ]);
    }

    public function toggleRole(int $id): RedirectResponse
    {
        if ($id === (int) session()->get('user_id')) {
            return redirect()->to('/admin/users')->with('error', 'Anda tidak dapat mengubah role akun sendiri yang sedang aktif.');
        }

        $userModel = new UserModel();
        $user      = $userModel->find($id);
        if (! $user) {
            return redirect()->to('/admin/users')->with('error', 'Pengguna tidak ditemukan.');
        }

        $newRole = $user['role'] === 'admin' ? 'user' : 'admin';
        $userModel->skipValidation(true)->update($id, ['role' => $newRole]);

        return redirect()->to('/admin/users')->with('success', "Role {$user['username']} berhasil diubah menjadi {$newRole}.");
    }
}

