<?php

namespace App\Controllers;

class HelloController extends BaseController
{
    public function index(): string
    {
        return view('hello/index', [
            'title' => 'Hello World — CodeIgniter 4',
            'nama'  => 'Dunia CodeIgniter 4',
            'pesan' => 'Selamat datang di Latihan 1 PBKK — Instalasi, Konfigurasi, Router, dan Controller.',
        ]);
    }

    public function sapa(string $nama): string
    {
        $namaBersih = urldecode($nama);

        return view('hello/index', [
            'title' => 'Sapa ' . $namaBersih . ' — CodeIgniter 4',
            'nama'  => $namaBersih,
            'pesan' => 'Halo ' . $namaBersih . '! Parameter ini ditangkap menggunakan route placeholder (:segment).',
        ]);
    }
}

