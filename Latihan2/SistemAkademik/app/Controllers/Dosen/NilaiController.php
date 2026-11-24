<?php

namespace App\Controllers\Dosen;

use App\Models\KelasModel;
use App\Models\KrsModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class NilaiController extends BaseDosenController
{
    public function daftarKelas(): string
    {
        $kelas = $this->dosen
            ? (new KelasModel())->getDaftarKelas(null, (int) $this->dosen['id'])
            : [];

        return $this->renderView('dosen/kelas', [
            'title' => 'Daftar Kelas yang Diampu',
            'dosen' => $this->dosen,
            'kelas' => $kelas,
        ]);
    }

    public function formNilai(int $kelasId): string
    {
        $kelas = (new KelasModel())->findDetail($kelasId);
        if (! $kelas || ! $this->dosen || (int) $kelas['dosen_id'] !== (int) $this->dosen['id']) {
            throw PageNotFoundException::forPageNotFound('Kelas tidak ditemukan atau bukan tanggung jawab Anda.');
        }

        return $this->renderView('dosen/nilai_form', [
            'title'   => 'Input Nilai — ' . $kelas['nama_mk'] . ' (' . $kelas['nama_kelas'] . ')',
            'dosen'   => $this->dosen,
            'kelas'   => $kelas,
            'peserta' => (new KrsModel())->getPesertaKelas($kelasId),
        ]);
    }

    public function simpanNilai(int $kelasId): RedirectResponse
    {
        $kelas = (new KelasModel())->findDetail($kelasId);
        if (! $kelas || ! $this->dosen || (int) $kelas['dosen_id'] !== (int) $this->dosen['id']) {
            return redirect()->to('/dosen/kelas')->with('error', 'Akses kelas tidak valid.');
        }

        $nilaiInput = (array) $this->request->getPost('nilai');
        $krsModel   = new KrsModel();
        $db         = db_connect();
        $db->transStart();

        $jumlahDisimpan = 0;
        foreach ($nilaiInput as $krsId => $skorRaw) {
            if ($skorRaw === '' || $skorRaw === null) {
                continue;
            }

            $skor = (float) $skorRaw;
            if ($skor < 0 || $skor > 100) {
                $db->transRollback();
                return redirect()->back()->withInput()->with('error', 'Nilai angka harus berada pada rentang 0 hingga 100.');
            }

            $krsRow = $krsModel->where('id', (int) $krsId)->where('kelas_id', $kelasId)->first();
            if (! $krsRow) {
                continue;
            }

            $konversi = konversi_nilai($skor);
            $krsModel->update((int) $krsId, [
                'nilai_angka' => round($skor, 2),
                'nilai_huruf' => $konversi['huruf'],
                'bobot'       => $konversi['bobot'],
                'status'      => $konversi['status'],
            ]);
            $jumlahDisimpan++;
        }

        $db->transComplete();

        if (! $db->transStatus()) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan nilai.');
        }

        return redirect()->to('/dosen/kelas/' . $kelasId . '/nilai')
            ->with('success', "Berhasil menyimpan nilai untuk {$jumlahDisimpan} mahasiswa.");
    }
}

