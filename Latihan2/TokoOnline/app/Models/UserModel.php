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
        'no_hp',
        'alamat_default',
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

