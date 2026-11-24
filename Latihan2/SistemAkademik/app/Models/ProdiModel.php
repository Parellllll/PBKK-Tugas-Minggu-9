<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdiModel extends Model
{
    protected $table            = 'prodi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['kode', 'nama', 'fakultas', 'jenjang'];

    protected $validationRules = [
        'kode'     => 'required|alpha_numeric|max_length[15]|is_unique[prodi.kode]',
        'nama'     => 'required|min_length[3]|max_length[100]',
        'fakultas' => 'required|max_length[120]',
        'jenjang'  => 'required|in_list[D3,D4,S1,S2,S3]',
    ];
}

