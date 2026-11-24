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
            return redirect()->to('/profil')->with('error', 'Akses ditolak. Halaman tersebut khusus untuk role: ' . implode(', ', $arguments) . '.');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}

