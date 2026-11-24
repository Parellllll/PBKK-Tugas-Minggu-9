<?php

namespace App\Controllers\Dosen;

use App\Models\KelasModel;

class DashboardController extends BaseDosenController
{
    public function index(): string
    {
        $kelasModel = new KelasModel();
        $semuaKelas = $this->dosen ? $kelasModel->getDaftarKelas(null, (int) $this->dosen['id']) : [];
        $kelasAktif = ($this->dosen && $this->tahunAktif)
            ? $kelasModel->getDaftarKelas((int) $this->tahunAktif['id'], (int) $this->dosen['id'])
            : [];

        $totalPeserta = array_sum(array_map(static fn ($k) => (int) $k['jumlah_peserta'], $kelasAktif));

        return $this->renderView('dosen/dashboard', [
            'title'        => 'Dashboard Dosen — SIAKAD',
            'dosen'        => $this->dosen,
            'kelasAktif'   => $kelasAktif,
            'totalKelas'   => count($semuaKelas),
            'totalPeserta' => $totalPeserta,
        ]);
    }
}

