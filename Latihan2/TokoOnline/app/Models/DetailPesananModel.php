<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPesananModel extends Model
{
    protected $table            = 'detail_pesanan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'pesanan_id',
        'produk_id',
        'nama_produk_snapshot',
        'harga_satuan',
        'qty',
        'subtotal',
    ];

    public function getByPesananId(int $pesananId): array
    {
        return $this->select('detail_pesanan.*, produk.kode, produk.slug')
            ->join('produk', 'produk.id = detail_pesanan.produk_id', 'left')
            ->where('detail_pesanan.pesanan_id', $pesananId)
            ->findAll();
    }
}

