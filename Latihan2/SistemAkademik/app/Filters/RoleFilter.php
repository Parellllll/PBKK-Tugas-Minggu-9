<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $role = session()->get('user_role');

        if ($arguments !== null && ! in_array($role, $arguments, true)) {
            $home = match ($role) {
                'admin'     => '/admin',
                'dosen'     => '/dosen',
                'mahasiswa' => '/mahasiswa',
                default     => '/login',
            };

            return redirect()->to($home)->with('error', 'Anda tidak memiliki izin untuk mengakses modul tersebut.');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}

