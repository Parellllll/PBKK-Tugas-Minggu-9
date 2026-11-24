<?php

namespace App\Models;

use CodeIgniter\Model;

class DosenModel extends Model
{
    protected $table            = 'dosen';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['user_id', 'prodi_id', 'nidn', 'nama', 'gelar_depan', 'gelar_belakang', 'email'];

    public function getAllWithRelasi(): array
    {
        return $this->select('dosen.*, prodi.nama AS nama_prodi, users.username')
            ->join('prodi', 'prodi.id = dosen.prodi_id')
            ->join('users', 'users.id = dosen.user_id')
            ->orderBy('dosen.nama', 'ASC')
            ->findAll();
    }

    public function findByUserId(int $userId): ?array
    {
        return $this->select('dosen.*, prodi.nama AS nama_prodi, prodi.fakultas')
            ->join('prodi', 'prodi.id = dosen.prodi_id')
            ->where('dosen.user_id', $userId)
            ->first();
    }
}

