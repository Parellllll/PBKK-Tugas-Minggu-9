<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'username',
        'nama_lengkap',
        'email',
        'password_hash',
        'role',
    ];

    protected $validationRules = [
        'username'     => 'required|alpha_dash|min_length[3]|max_length[50]|is_unique[users.username,id,{id}]',
        'nama_lengkap' => 'required|min_length[3]|max_length[120]',
        'email'        => 'required|valid_email|is_unique[users.email,id,{id}]',
        'role'         => 'in_list[admin,user]',
    ];

    public function findByIdentity(string $identity): ?array
    {
        return $this->groupStart()
            ->where('username', $identity)
            ->orWhere('email', $identity)
            ->groupEnd()
            ->first();
    }
}

