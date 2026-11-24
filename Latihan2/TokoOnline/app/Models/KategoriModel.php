<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table            = 'kategori';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama', 'slug', 'deskripsi'];

    protected $validationRules = [
        'nama' => 'required|min_length[2]|max_length[80]',
        'slug' => 'required|alpha_dash|max_length[100]|is_unique[kategori.slug]',
    ];

    public function getAllWithJumlahProduk(): array
    {
        return $this->db->table('kategori k')
            ->select('k.*, COUNT(p.id) AS jumlah_produk')
            ->join('produk p', 'p.kategori_id = k.id', 'left')
            ->groupBy('k.id')
            ->orderBy('k.nama', 'ASC')
            ->get()
            ->getResultArray();
    }
}

