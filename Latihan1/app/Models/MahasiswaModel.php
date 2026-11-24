<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table            = 'mahasiswa';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'nrp',
        'nama',
        'email',
        'prodi',
        'angkatan',
        'jenis_kelamin',
        'no_hp',
        'alamat',
        'ipk',
        'foto',
    ];

    protected $validationRules = [
        'id'            => 'permit_empty|integer',
        'nrp'           => 'required|numeric|min_length[8]|max_length[20]|is_unique[mahasiswa.nrp,id,{id}]',
        'nama'          => 'required|min_length[3]|max_length[120]',
        'email'         => 'required|valid_email|max_length[120]',
        'prodi'         => 'required|max_length[80]',
        'angkatan'      => 'required|integer|greater_than_equal_to[2015]|less_than_equal_to[2030]',
        'jenis_kelamin' => 'required|in_list[L,P]',
        'no_hp'         => 'permit_empty|max_length[25]',
        'alamat'        => 'permit_empty|max_length[500]',
        'ipk'           => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[4]',
    ];

    protected $validationMessages = [
        'nrp' => [
            'required'  => 'NRP wajib diisi.',
            'numeric'   => 'NRP hanya boleh berisi angka.',
            'is_unique' => 'NRP sudah terdaftar di sistem.',
        ],
        'nama' => [
            'required'   => 'Nama mahasiswa wajib diisi.',
            'min_length' => 'Nama minimal terdiri dari 3 karakter.',
        ],
        'email' => [
            'required'    => 'Email wajib diisi.',
            'valid_email' => 'Format email tidak valid.',
        ],
        'ipk' => [
            'greater_than_equal_to' => 'IPK harus berada pada rentang 0.00 sampai 4.00.',
            'less_than_equal_to'    => 'IPK harus berada pada rentang 0.00 sampai 4.00.',
        ],
    ];

    public const DAFTAR_PRODI = [
        'Teknik Informatika',
        'Rekayasa Perangkat Lunak',
        'Rekayasa Kecerdasan Artifisial',
        'Sistem Informasi',
        'Teknologi Informasi',
    ];

    public function filterAndPaginate(?string $keyword = null, ?string $prodi = null, int $perPage = 6): array
    {
        if ($keyword !== null && trim($keyword) !== '') {
            $kw = trim($keyword);
            $this->groupStart()
                ->like('nrp', $kw)
                ->orLike('nama', $kw)
                ->orLike('email', $kw)
                ->orLike('alamat', $kw)
                ->groupEnd();
        }

        if ($prodi !== null && trim($prodi) !== '') {
            $this->where('prodi', $prodi);
        }

        return $this->orderBy('angkatan', 'DESC')
            ->orderBy('nrp', 'ASC')
            ->paginate($perPage);
    }

    public function getRingkasan(): array
    {
        $row = $this->db->table($this->table)
            ->select('COUNT(*) AS total, AVG(ipk) AS rata_ipk, MAX(ipk) AS max_ipk')
            ->get()
            ->getRowArray();

        $perProdi = $this->db->table($this->table)
            ->select('prodi, COUNT(*) AS jumlah, AVG(ipk) AS rata_ipk')
            ->groupBy('prodi')
            ->orderBy('jumlah', 'DESC')
            ->get()
            ->getResultArray();

        return [
            'total'     => (int) ($row['total'] ?? 0),
            'rata_ipk'  => round((float) ($row['rata_ipk'] ?? 0), 2),
            'max_ipk'   => round((float) ($row['max_ipk'] ?? 0), 2),
            'per_prodi' => $perProdi,
        ];
    }
}

