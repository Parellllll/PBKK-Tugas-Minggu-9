<?php

namespace App\Models;

use CodeIgniter\Model;

class TahunAkademikModel extends Model
{
    protected $table            = 'tahun_akademik';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['kode', 'nama', 'semester', 'is_aktif'];

    protected $validationRules = [
        'kode'     => 'required|alpha_numeric|max_length[15]|is_unique[tahun_akademik.kode]',
        'nama'     => 'required|max_length[80]',
        'semester' => 'required|in_list[Ganjil,Genap]',
    ];

    public function getAktif(): ?array
    {
        return $this->where('is_aktif', 1)->first() ?? $this->orderBy('id', 'DESC')->first();
    }

    public function aktifkan(int $id): bool
    {
        $this->db->transStart();
        $this->db->table($this->table)->update(['is_aktif' => 0]);
        $this->db->table($this->table)->where('id', $id)->update(['is_aktif' => 1]);
        $this->db->transComplete();

        return $this->db->transStatus();
    }
}

