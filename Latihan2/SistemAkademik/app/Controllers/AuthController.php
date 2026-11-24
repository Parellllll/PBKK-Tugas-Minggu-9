<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class AuthController extends BaseController
{
    public function redirectHome(): RedirectResponse
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        return redirect()->to($this->homeByRole((string) session()->get('user_role')));
    }

    public function loginForm(): string|RedirectResponse
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to($this->homeByRole((string) session()->get('user_role')));
        }

        return view('auth/login', [
            'title' => 'Login — SIAKAD CodeIgniter 4',
        ]);
    }

    public function login(): RedirectResponse
    {
        $identity = trim((string) $this->request->getPost('identity'));
        $password = (string) $this->request->getPost('password');

        $userModel = new UserModel();
        $user      = $userModel->findByIdentity($identity);

        if (! $user || ! password_verify($password, $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Username/Email atau password salah.');
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

        return redirect()->to($this->homeByRole($user['role']))
            ->with('success', 'Selamat datang di SIAKAD, ' . $user['nama_lengkap'] . '!');
    }

    public function logout(): RedirectResponse
    {
        session()->destroy();

        return redirect()->to('/login')->with('success', 'Anda telah keluar dari SIAKAD.');
    }

    private function homeByRole(string $role): string
    {
        return match ($role) {
            'admin'     => '/admin',
            'dosen'     => '/dosen',
            'mahasiswa' => '/mahasiswa',
            default     => '/login',
        };
    }
}

