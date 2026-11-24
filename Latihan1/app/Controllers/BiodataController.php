<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class BiodataController extends BaseController
{
    public function index(): string
    {
        $model   = new MahasiswaModel();
        $keyword = $this->request->getGet('q');
        $prodi   = $this->request->getGet('prodi');

        return view('biodata/index', [
            'title'        => 'Direktori Biodata Mahasiswa',
            'mahasiswa'    => $model->filterAndPaginate($keyword, $prodi, 6),
            'pager'        => $model->pager,
            'keyword'      => $keyword ?? '',
            'prodiAktif'   => $prodi ?? '',
            'daftarProdi'  => MahasiswaModel::DAFTAR_PRODI,
        ]);
    }

    public function detail(string $nrp): string
    {
        $model = new MahasiswaModel();
        $mhs   = $model->where('nrp', $nrp)->first();

        if (! $mhs) {
            throw PageNotFoundException::forPageNotFound('Mahasiswa dengan NRP ' . $nrp . ' tidak ditemukan.');
        }

        return view('biodata/detail', [
            'title' => 'Biodata ' . $mhs['nama'],
            'mhs'   => $mhs,
        ]);
    }
}

