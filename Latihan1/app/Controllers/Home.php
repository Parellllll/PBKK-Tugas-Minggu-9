<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;

class Home extends BaseController
{
    public function index(): string
    {
        $model = new MahasiswaModel();

        return view('home/index', [
            'title'      => 'Beranda — Biodata Mahasiswa CI4',
            'ringkasan'  => $model->getRingkasan(),
            'terbaru'    => $model->orderBy('created_at', 'DESC')->findAll(4),
        ]);
    }

    public function about(): string
    {
        return view('home/about', [
            'title' => 'Tentang Praktikum — Latihan 1 PBKK',
        ]);
    }
}
