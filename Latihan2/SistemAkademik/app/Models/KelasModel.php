<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table            = 'kelas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['mata_kuliah_id', 'dosen_id', 'tahun_akademik_id', 'nama_kelas', 'jadwal', 'ruangan', 'kuota'];

    protected $validationRules = [
        'mata_kuliah_id'    => 'required|integer',
        'dosen_id'          => 'required|integer',
        'tahun_akademik_id' => 'required|integer',
        'nama_kelas'        => 'required|max_length[20]',
        'jadwal'            => 'required|max_length[80]',
        'ruangan'           => 'required|max_length[40]',
        'kuota'             => 'required|integer|greater_than_equal_to[5]|less_than_equal_to[200]',
    ];

    public function getDaftarKelas(?int $tahunAkademikId = null, ?int $dosenId = null): array
    {
        $builder = $this->db->table('kelas k')
            ->select('k.*, mk.kode AS kode_mk, mk.nama AS nama_mk, mk.sks, mk.semester_paket, d.nama AS nama_dosen, d.gelar_depan, d.gelar_belakang, ta.nama AS nama_ta, ta.is_aktif, COUNT(krs.id) AS jumlah_peserta')
            ->join('mata_kuliah mk', 'mk.id = k.mata_kuliah_id')
            ->join('dosen d', 'd.id = k.dosen_id')
            ->join('tahun_akademik ta', 'ta.id = k.tahun_akademik_id')
            ->join('krs', 'krs.kelas_id = k.id', 'left')
            ->groupBy('k.id')
            ->orderBy('ta.id', 'DESC')
            ->orderBy('mk.kode', 'ASC');

        if ($tahunAkademikId !== null) {
            $builder->where('k.tahun_akademik_id', $tahunAkademikId);
        }

        if ($dosenId !== null) {
            $builder->where('k.dosen_id', $dosenId);
        }

        return $builder->get()->getResultArray();
    }

    public function findDetail(int $kelasId): ?array
    {
        $row = $this->db->table('kelas k')
            ->select('k.*, mk.kode AS kode_mk, mk.nama AS nama_mk, mk.sks, d.nama AS nama_dosen, d.gelar_depan, d.gelar_belakang, ta.nama AS nama_ta')
            ->join('mata_kuliah mk', 'mk.id = k.mata_kuliah_id')
            ->join('dosen d', 'd.id = k.dosen_id')
            ->join('tahun_akademik ta', 'ta.id = k.tahun_akademik_id')
            ->where('k.id', $kelasId)
            ->get()
            ->getRowArray();

        return $row ?: null;
    }
}

