<?php

namespace App\Models;

use CodeIgniter\Model;

class MataKuliahModel extends Model
{
    protected $table            = 'mata_kuliah';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['prodi_id', 'kode', 'nama', 'sks', 'semester_paket'];

    protected $validationRules = [
        'prodi_id'       => 'required|integer',
        'kode'           => 'required|alpha_numeric|max_length[20]|is_unique[mata_kuliah.kode]',
        'nama'           => 'required|min_length[3]|max_length[120]',
        'sks'            => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[6]',
        'semester_paket' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[8]',
    ];

    public function getAllWithProdi(): array
    {
        return $this->select('mata_kuliah.*, prodi.nama AS nama_prodi, prodi.kode AS kode_prodi')
            ->join('prodi', 'prodi.id = mata_kuliah.prodi_id')
            ->orderBy('mata_kuliah.semester_paket', 'ASC')
            ->orderBy('mata_kuliah.kode', 'ASC')
            ->findAll();
    }
}

