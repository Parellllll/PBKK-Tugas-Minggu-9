<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table            = 'produk';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'kategori_id',
        'kode',
        'nama',
        'slug',
        'deskripsi',
        'harga',
        'stok',
        'gambar',
        'is_aktif',
    ];

    protected $validationRules = [
        'kategori_id' => 'required|integer',
        'kode'        => 'required|max_length[30]',
        'nama'        => 'required|min_length[3]|max_length[150]',
        'slug'        => 'required|max_length[180]',
        'harga'       => 'required|integer|greater_than[0]',
        'stok'        => 'required|integer|greater_than_equal_to[0]',
    ];

    /**
     * Query Builder dengan filter, sorting, subquery total_terjual, dan pagination.
     */
    public function filterKatalog(array $filters = [], int $perPage = 8, bool $hanyaAktif = true): array
    {
        $subqueryTerjual = '(SELECT COALESCE(SUM(dp.qty), 0) FROM detail_pesanan dp INNER JOIN pesanan ps ON ps.id = dp.pesanan_id WHERE dp.produk_id = produk.id AND ps.status != \'dibatalkan\')';

        $this->select("produk.*, kategori.nama AS nama_kategori, kategori.slug AS slug_kategori, {$subqueryTerjual} AS total_terjual", false)
            ->join('kategori', 'kategori.id = produk.kategori_id');

        if ($hanyaAktif) {
            $this->where('produk.is_aktif', 1);
        }

        if (! empty($filters['q'])) {
            $kw = trim((string) $filters['q']);
            $this->groupStart()
                ->like('produk.nama', $kw)
                ->orLike('produk.kode', $kw)
                ->orLike('produk.deskripsi', $kw)
                ->groupEnd();
        }

        if (! empty($filters['kategori'])) {
            $this->where('kategori.slug', (string) $filters['kategori']);
        }

        if (isset($filters['min_harga']) && $filters['min_harga'] !== '' && is_numeric($filters['min_harga'])) {
            $this->where('produk.harga >=', (int) $filters['min_harga']);
        }

        if (isset($filters['max_harga']) && $filters['max_harga'] !== '' && is_numeric($filters['max_harga'])) {
            $this->where('produk.harga <=', (int) $filters['max_harga']);
        }

        $sort = $filters['sort'] ?? 'terbaru';
        match ($sort) {
            'termurah' => $this->orderBy('produk.harga', 'ASC'),
            'termahal' => $this->orderBy('produk.harga', 'DESC'),
            'terlaris' => $this->orderBy('total_terjual', 'DESC')->orderBy('produk.id', 'DESC'),
            default    => $this->orderBy('produk.id', 'DESC'),
        };

        return $this->paginate($perPage);
    }

    public function findBySlug(string $slug): ?array
    {
        $subqueryTerjual = '(SELECT COALESCE(SUM(dp.qty), 0) FROM detail_pesanan dp INNER JOIN pesanan ps ON ps.id = dp.pesanan_id WHERE dp.produk_id = produk.id AND ps.status != \'dibatalkan\')';

        return $this->select("produk.*, kategori.nama AS nama_kategori, kategori.slug AS slug_kategori, {$subqueryTerjual} AS total_terjual", false)
            ->join('kategori', 'kategori.id = produk.kategori_id')
            ->where('produk.slug', $slug)
            ->first();
    }
}

