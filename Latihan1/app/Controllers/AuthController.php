<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class AuthController extends BaseController
{
    public function loginForm(): string|RedirectResponse
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(session()->get('user_role') === 'admin' ? '/admin' : '/profil');
        }

        return view('auth/login', [
            'title' => 'Login — Biodata Mahasiswa',
        ]);
    }

    public function login(): RedirectResponse
    {
        $identity = trim((string) $this->request->getPost('identity'));
        $password = (string) $this->request->getPost('password');

        if ($identity === '' || $password === '') {
            return redirect()->back()->withInput()->with('error', 'Username/Email dan password wajib diisi.');
        }

        $userModel = new UserModel();
        $user      = $userModel->findByIdentity($identity);

        if (! $user || ! password_verify($password, $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Kredensial tidak valid. Periksa username/email dan password Anda.');
        }

        session()->regenerate();
        session()->set([
            'isLoggedIn' => true,
            'user_id'    => $user['id'],
            'username'   => $user['username'],
            'user_nama'  => $user['nama_lengkap'],
            'user_email' => $user['email'],
            'user_role'  => $user['role'],
        ]);

        $target = $user['role'] === 'admin' ? '/admin' : '/profil';

        return redirect()->to($target)->with('success', 'Selamat datang kembali, ' . $user['nama_lengkap'] . '!');
    }

    public function registerForm(): string|RedirectResponse
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/profil');
        }

        return view('auth/register', [
            'title' => 'Registrasi Akun — Biodata Mahasiswa',
        ]);
    }

    public function register(): RedirectResponse
    {
        $rules = [
            'username'         => 'required|alpha_dash|min_length[3]|max_length[50]|is_unique[users.username]',
            'nama_lengkap'     => 'required|min_length[3]|max_length[120]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $userModel->skipValidation(true)->insert([
            'username'      => trim((string) $this->request->getPost('username')),
            'nama_lengkap'  => trim((string) $this->request->getPost('nama_lengkap')),
            'email'         => trim((string) $this->request->getPost('email')),
            'password_hash' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'          => 'user',
        ]);

        return redirect()->to('/login')->with('success', 'Registrasi berhasil! Silakan login dengan akun baru Anda.');
    }

    public function logout(): RedirectResponse
    {
        session()->destroy();

        return redirect()->to('/login')->with('success', 'Anda telah keluar dari sistem.');
    }
}

