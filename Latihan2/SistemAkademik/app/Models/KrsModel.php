<?php

namespace App\Models;

use CodeIgniter\Model;

class KrsModel extends Model
{
    protected $table            = 'krs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'mahasiswa_id',
        'kelas_id',
        'tahun_akademik_id',
        'nilai_angka',
        'nilai_huruf',
        'bobot',
        'status',
    ];

    public function getKrsMahasiswa(int $mahasiswaId, ?int $tahunAkademikId = null): array
    {
        $builder = $this->db->table('krs')
            ->select('krs.*, k.nama_kelas, k.jadwal, k.ruangan, mk.kode AS kode_mk, mk.nama AS nama_mk, mk.sks, mk.semester_paket, d.nama AS nama_dosen, d.gelar_depan, d.gelar_belakang, ta.nama AS nama_ta, ta.kode AS kode_ta')
            ->join('kelas k', 'k.id = krs.kelas_id')
            ->join('mata_kuliah mk', 'mk.id = k.mata_kuliah_id')
            ->join('dosen d', 'd.id = k.dosen_id')
            ->join('tahun_akademik ta', 'ta.id = krs.tahun_akademik_id')
            ->where('krs.mahasiswa_id', $mahasiswaId)
            ->orderBy('ta.kode', 'ASC')
            ->orderBy('mk.kode', 'ASC');

        if ($tahunAkademikId !== null) {
            $builder->where('krs.tahun_akademik_id', $tahunAkademikId);
        }

        return $builder->get()->getResultArray();
    }

    public function getTotalSksSemester(int $mahasiswaId, int $tahunAkademikId): int
    {
        $row = $this->db->table('krs')
            ->selectSum('mk.sks', 'total_sks')
            ->join('kelas k', 'k.id = krs.kelas_id')
            ->join('mata_kuliah mk', 'mk.id = k.mata_kuliah_id')
            ->where('krs.mahasiswa_id', $mahasiswaId)
            ->where('krs.tahun_akademik_id', $tahunAkademikId)
            ->get()
            ->getRowArray();

        return (int) ($row['total_sks'] ?? 0);
    }

    public function getPesertaKelas(int $kelasId): array
    {
        return $this->db->table('krs')
            ->select('krs.*, m.nrp, m.nama AS nama_mahasiswa, m.angkatan, p.nama AS nama_prodi')
            ->join('mahasiswa m', 'm.id = krs.mahasiswa_id')
            ->join('prodi p', 'p.id = m.prodi_id')
            ->where('krs.kelas_id', $kelasId)
            ->orderBy('m.nrp', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Menghitung ringkasan IP / IPK menggunakan agregasi JOIN.
     *
     * @return array{sks_diambil: int, sks_dinilai: int, total_mutu: float, ips_atau_ipk: float}
     */
    public function hitungIndeksPrestasi(int $mahasiswaId, ?int $tahunAkademikId = null): array
    {
        $builder = $this->db->table('krs')
            ->select('SUM(mk.sks) AS sks_diambil, SUM(CASE WHEN krs.bobot IS NOT NULL THEN mk.sks ELSE 0 END) AS sks_dinilai, SUM(CASE WHEN krs.bobot IS NOT NULL THEN mk.sks * krs.bobot ELSE 0 END) AS total_mutu')
            ->join('kelas k', 'k.id = krs.kelas_id')
            ->join('mata_kuliah mk', 'mk.id = k.mata_kuliah_id')
            ->where('krs.mahasiswa_id', $mahasiswaId);

        if ($tahunAkademikId !== null) {
            $builder->where('krs.tahun_akademik_id', $tahunAkademikId);
        }

        $row        = $builder->get()->getRowArray();
        $sksDiambil = (int) ($row['sks_diambil'] ?? 0);
        $sksDinilai = (int) ($row['sks_dinilai'] ?? 0);
        $totalMutu  = (float) ($row['total_mutu'] ?? 0.0);
        $ip         = $sksDinilai > 0 ? round($totalMutu / $sksDinilai, 2) : 0.00;

        return [
            'sks_diambil'  => $sksDiambil,
            'sks_dinilai'  => $sksDinilai,
            'total_mutu'   => round($totalMutu, 2),
            'ips_atau_ipk' => $ip,
        ];
    }

    public function sudahAmbilMataKuliah(int $mahasiswaId, int $mataKuliahId, int $tahunAkademikId): bool
    {
        $count = $this->db->table('krs')
            ->join('kelas k', 'k.id = krs.kelas_id')
            ->where('krs.mahasiswa_id', $mahasiswaId)
            ->where('krs.tahun_akademik_id', $tahunAkademikId)
            ->where('k.mata_kuliah_id', $mataKuliahId)
            ->countAllResults();

        return $count > 0;
    }
}

