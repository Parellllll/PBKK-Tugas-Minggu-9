<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('isLoggedIn')) {
            // Simpan URL tujuan agar setelah login langsung kembali ke halaman yang diminta (misal /checkout)
            $currentUri = (string) current_url(true);
            session()->set('redirect_url', $currentUri);

            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu untuk melanjutkan.');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}

