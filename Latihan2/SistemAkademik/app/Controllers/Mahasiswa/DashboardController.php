<?php

namespace App\Controllers\Mahasiswa;

use App\Models\KrsModel;

class DashboardController extends BaseMahasiswaController
{
    public function index(): string
    {
        $krsModel  = new KrsModel();
        $mhsId     = (int) ($this->mahasiswa['id'] ?? 0);
        $taId      = $this->tahunAktif ? (int) $this->tahunAktif['id'] : null;

        $krsAktif  = ($mhsId && $taId) ? $krsModel->getKrsMahasiswa($mhsId, $taId) : [];
        $sksAktif  = ($mhsId && $taId) ? $krsModel->getTotalSksSemester($mhsId, $taId) : 0;
        $ipkData   = $mhsId ? $krsModel->hitungIndeksPrestasi($mhsId) : ['sks_diambil' => 0, 'sks_dinilai' => 0, 'total_mutu' => 0, 'ips_atau_ipk' => 0.00];

        return $this->renderView('mahasiswa/dashboard', [
            'title'     => 'Dashboard Mahasiswa — SIAKAD',
            'mahasiswa' => $this->mahasiswa,
            'krsAktif'  => $krsAktif,
            'sksAktif'  => $sksAktif,
            'ipkData'   => $ipkData,
        ]);
    }
}

