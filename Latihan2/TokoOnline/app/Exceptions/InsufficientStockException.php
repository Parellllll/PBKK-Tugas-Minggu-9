<?php

namespace App\Exceptions;

use RuntimeException;

class InsufficientStockException extends RuntimeException
{
    public function __construct(
        public readonly string $namaProduk,
        public readonly int $stokTersedia,
        public readonly int $jumlahDiminta
    ) {
        parent::__construct(
            "Stok produk \"{$namaProduk}\" tidak mencukupi (tersedia: {$stokTersedia}, diminta: {$jumlahDiminta}). Transaksi dibatalkan dan stok di-rollback."
        );
    }
}

