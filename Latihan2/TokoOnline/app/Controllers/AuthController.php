<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class AuthController extends BaseController
{
    public function loginForm(): string|RedirectResponse
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(session()->get('user_role') === 'admin' ? '/admin' : '/');
        }

        return view('auth/login', [
            'title' => 'Login — TokoKita',
        ]);
    }

    public function login(): RedirectResponse
    {
        $identity = trim((string) $this->request->getPost('identity'));
        $password = (string) $this->request->getPost('password');

        $user = (new UserModel())->findByIdentity($identity);
        if (! $user || ! password_verify($password, $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Username/Email atau password salah.');
        }

        // Ambil URL tujuan sebelum regenerate session
        $intendedUrl = session()->get('redirect_url');
        session()->remove('redirect_url');

        session()->regenerate();
        session()->set([
            'isLoggedIn' => true,
            'user_id'    => $user['id'],
            'username'   => $user['username'],
            'user_nama'  => $user['nama_lengkap'],
            'user_email' => $user['email'],
            'user_role'  => $user['role'],
        ]);

        if (is_string($intendedUrl) && $intendedUrl !== '') {
            return redirect()->to($intendedUrl)->with('success', 'Login berhasil! Melanjutkan ke halaman tujuan Anda.');
        }

        $defaultTarget = $user['role'] === 'admin' ? '/admin' : '/';

        return redirect()->to($defaultTarget)->with('success', 'Selamat datang kembali, ' . $user['nama_lengkap'] . '!');
    }

    public function registerForm(): string|RedirectResponse
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        return view('auth/register', [
            'title' => 'Daftar Pelanggan — TokoKita',
        ]);
    }

    public function register(): RedirectResponse
    {
        $rules = [
            'username'         => 'required|alpha_dash|min_length[3]|is_unique[users.username]',
            'nama_lengkap'     => 'required|min_length[3]|max_length[120]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new UserModel())->insert([
            'username'       => trim((string) $this->request->getPost('username')),
            'nama_lengkap'   => trim((string) $this->request->getPost('nama_lengkap')),
            'email'          => trim((string) $this->request->getPost('email')),
            'password_hash'  => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'           => 'customer',
            'no_hp'          => trim((string) $this->request->getPost('no_hp')),
            'alamat_default' => trim((string) $this->request->getPost('alamat_default')),
        ]);

        return redirect()->to('/login')->with('success', 'Registrasi berhasil! Silakan login untuk mulai berbelanja.');
    }

    public function logout(): RedirectResponse
    {
        session()->destroy();

        return redirect()->to('/')->with('success', 'Anda telah keluar dari TokoKita.');
    }
}

