<?php

namespace App\Models;

use CodeIgniter\Model;

class PesananModel extends Model
{
    protected $table            = 'pesanan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'kode_invoice',
        'user_id',
        'nama_penerima',
        'no_hp',
        'alamat_pengiriman',
        'metode_pembayaran',
        'ongkir',
        'subtotal',
        'total',
        'status',
        'catatan',
    ];

    public function getRiwayatUser(int $userId): array
    {
        return $this->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->findAll();
    }

    public function getAllWithCustomer(?string $status = null): array
    {
        $builder = $this->select('pesanan.*, users.username, users.email')
            ->join('users', 'users.id = pesanan.user_id')
            ->orderBy('pesanan.id', 'DESC');

        if ($status !== null && $status !== '') {
            $builder->where('pesanan.status', $status);
        }

        return $builder->findAll();
    }

    public function findByInvoice(string $invoice): ?array
    {
        return $this->select('pesanan.*, users.username, users.email')
            ->join('users', 'users.id = pesanan.user_id')
            ->where('pesanan.kode_invoice', $invoice)
            ->first();
    }

    public function getStatistik(): array
    {
        $omzet = $this->db->table($this->table)
            ->select('COUNT(*) AS total_pesanan, COALESCE(SUM(CASE WHEN status != \'dibatalkan\' THEN total ELSE 0 END), 0) AS total_omzet, SUM(CASE WHEN status = \'pending\' THEN 1 ELSE 0 END) AS pending_count')
            ->get()
            ->getRowArray();

        return [
            'total_pesanan' => (int) ($omzet['total_pesanan'] ?? 0),
            'total_omzet'   => (int) ($omzet['total_omzet'] ?? 0),
            'pending_count' => (int) ($omzet['pending_count'] ?? 0),
        ];
    }
}

