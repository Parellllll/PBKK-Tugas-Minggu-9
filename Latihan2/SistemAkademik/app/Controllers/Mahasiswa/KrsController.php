<?php

namespace App\Controllers\Mahasiswa;

use App\Models\KelasModel;
use App\Models\KrsModel;
use CodeIgniter\HTTP\RedirectResponse;

class KrsController extends BaseMahasiswaController
{
    public function index(): string
    {
        $mhsId      = (int) ($this->mahasiswa['id'] ?? 0);
        $taId       = (int) ($this->tahunAktif['id'] ?? 0);
        $krsModel   = new KrsModel();
        $kelasModel = new KelasModel();

        $krsDiambil   = ($mhsId && $taId) ? $krsModel->getKrsMahasiswa($mhsId, $taId) : [];
        $kelasDiambil = array_column($krsDiambil, 'kelas_id');
        $sksDiambil   = ($mhsId && $taId) ? $krsModel->getTotalSksSemester($mhsId, $taId) : 0;

        return $this->renderView('mahasiswa/krs', [
            'title'        => 'Kartu Rencana Studi (KRS)',
            'mahasiswa'    => $this->mahasiswa,
            'krsDiambil'   => $krsDiambil,
            'kelasTersedia'=> $taId ? $kelasModel->getDaftarKelas($taId) : [],
            'kelasDiambil' => array_map('intval', $kelasDiambil),
            'sksDiambil'   => $sksDiambil,
            'maxSks'       => $this->akademikConfig->maxSksPerSemester,
        ]);
    }

    public function ambil(): RedirectResponse
    {
        if (! $this->mahasiswa || ! $this->tahunAktif) {
            return redirect()->to('/mahasiswa/krs')->with('error', 'Data mahasiswa atau tahun akademik aktif tidak ditemukan.');
        }

        $kelasId = (int) $this->request->getPost('kelas_id');
        $mhsId   = (int) $this->mahasiswa['id'];
        $taId    = (int) $this->tahunAktif['id'];

        $kelasModel = new KelasModel();
        $krsModel   = new KrsModel();
        $kelas      = $kelasModel->findDetail($kelasId);

        if (! $kelas || (int) $kelas['tahun_akademik_id'] !== $taId) {
            return redirect()->to('/mahasiswa/krs')->with('error', 'Kelas tidak tersedia pada semester aktif.');
        }

        if ($krsModel->sudahAmbilMataKuliah($mhsId, (int) $kelas['mata_kuliah_id'], $taId)) {
            return redirect()->to('/mahasiswa/krs')->with('error', 'Anda sudah mengambil mata kuliah ' . $kelas['nama_mk'] . ' pada semester ini.');
        }

        $sksSekarang = $krsModel->getTotalSksSemester($mhsId, $taId);
        if ($sksSekarang + (int) $kelas['sks'] > $this->akademikConfig->maxSksPerSemester) {
            return redirect()->to('/mahasiswa/krs')->with('error', 'Melebihi batas maksimal ' . $this->akademikConfig->maxSksPerSemester . ' SKS per semester.');
        }

        $db = db_connect();
        $db->transStart();

        $terisi = $db->table('krs')->where('kelas_id', $kelasId)->countAllResults();
        if ($terisi >= (int) $kelas['kuota']) {
            $db->transRollback();
            return redirect()->to('/mahasiswa/krs')->with('error', 'Kuota kelas ' . $kelas['nama_kelas'] . ' sudah penuh.');
        }

        $krsModel->insert([
            'mahasiswa_id'      => $mhsId,
            'kelas_id'          => $kelasId,
            'tahun_akademik_id' => $taId,
            'status'            => 'diambil',
        ]);

        $db->transComplete();

        if (! $db->transStatus()) {
            return redirect()->to('/mahasiswa/krs')->with('error', 'Gagal menyimpan KRS.');
        }

        return redirect()->to('/mahasiswa/krs')->with('success', 'Berhasil mengambil kelas ' . $kelas['nama_mk'] . ' (' . $kelas['nama_kelas'] . ').');
    }

    public function hapus(int $krsId): RedirectResponse
    {
        $mhsId    = (int) ($this->mahasiswa['id'] ?? 0);
        $krsModel = new KrsModel();
        $row      = $krsModel->where('id', $krsId)->where('mahasiswa_id', $mhsId)->first();

        if (! $row) {
            return redirect()->to('/mahasiswa/krs')->with('error', 'Data KRS tidak ditemukan.');
        }

        if ($row['nilai_angka'] !== null) {
            return redirect()->to('/mahasiswa/krs')->with('error', 'Mata kuliah yang sudah memiliki nilai tidak dapat dibatalkan.');
        }

        $krsModel->delete($krsId);

        return redirect()->to('/mahasiswa/krs')->with('success', 'Mata kuliah berhasil dihapus dari KRS.');
    }
}

