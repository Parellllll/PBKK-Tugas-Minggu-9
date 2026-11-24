<?php

namespace App\Controllers\Mahasiswa;

use App\Models\KrsModel;
use App\Models\TahunAkademikModel;

class KhsController extends BaseMahasiswaController
{
    public function index(): string
    {
        $mhsId         = (int) ($this->mahasiswa['id'] ?? 0);
        $semuaTa       = (new TahunAkademikModel())->orderBy('kode', 'DESC')->findAll();
        $selectedTaId  = (int) ($this->request->getGet('ta') ?? ($this->tahunAktif['id'] ?? ($semuaTa[0]['id'] ?? 0)));
        $krsModel      = new KrsModel();

        $daftarNilai   = ($mhsId && $selectedTaId) ? $krsModel->getKrsMahasiswa($mhsId, $selectedTaId) : [];
        $ipsSummary    = ($mhsId && $selectedTaId) ? $krsModel->hitungIndeksPrestasi($mhsId, $selectedTaId) : ['sks_diambil' => 0, 'sks_dinilai' => 0, 'total_mutu' => 0, 'ips_atau_ipk' => 0.00];
        $ipkSummary    = $mhsId ? $krsModel->hitungIndeksPrestasi($mhsId) : ['sks_diambil' => 0, 'sks_dinilai' => 0, 'total_mutu' => 0, 'ips_atau_ipk' => 0.00];

        return $this->renderView('mahasiswa/khs', [
            'title'        => 'Kartu Hasil Studi (KHS)',
            'mahasiswa'    => $this->mahasiswa,
            'semuaTa'      => $semuaTa,
            'selectedTaId' => $selectedTaId,
            'daftarNilai'  => $daftarNilai,
            'ipsSummary'   => $ipsSummary,
            'ipkSummary'   => $ipkSummary,
        ]);
    }

    public function transkrip(): string
    {
        $mhsId      = (int) ($this->mahasiswa['id'] ?? 0);
        $krsModel   = new KrsModel();
        $semuaKrs   = $mhsId ? $krsModel->getKrsMahasiswa($mhsId) : [];
        $ipkSummary = $mhsId ? $krsModel->hitungIndeksPrestasi($mhsId) : ['sks_diambil' => 0, 'sks_dinilai' => 0, 'total_mutu' => 0, 'ips_atau_ipk' => 0.00];

        return $this->renderView('mahasiswa/transkrip', [
            'title'      => 'Transkrip Nilai Kumulatif',
            'mahasiswa'  => $this->mahasiswa,
            'semuaKrs'   => $semuaKrs,
            'ipkSummary' => $ipkSummary,
        ]);
    }
}

