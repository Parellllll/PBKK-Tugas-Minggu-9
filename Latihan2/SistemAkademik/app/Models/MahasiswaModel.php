<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table            = 'mahasiswa';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['user_id', 'prodi_id', 'nrp', 'nama', 'angkatan', 'status'];

    public function getAllWithRelasi(?string $keyword = null): array
    {
        $builder = $this->select('mahasiswa.*, prodi.nama AS nama_prodi, prodi.kode AS kode_prodi, users.username, users.email')
            ->join('prodi', 'prodi.id = mahasiswa.prodi_id')
            ->join('users', 'users.id = mahasiswa.user_id');

        if ($keyword !== null && trim($keyword) !== '') {
            $kw = trim($keyword);
            $builder->groupStart()
                ->like('mahasiswa.nrp', $kw)
                ->orLike('mahasiswa.nama', $kw)
                ->orLike('prodi.nama', $kw)
                ->groupEnd();
        }

        return $builder->orderBy('mahasiswa.nrp', 'ASC')->findAll();
    }

    public function findByUserId(int $userId): ?array
    {
        return $this->select('mahasiswa.*, prodi.nama AS nama_prodi, prodi.kode AS kode_prodi, prodi.fakultas')
            ->join('prodi', 'prodi.id = mahasiswa.prodi_id')
            ->where('mahasiswa.user_id', $userId)
            ->first();
    }
}

