<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Toko extends BaseConfig
{
    public string $namaToko = 'TokoKita — Storefront CI4';
    public int $ongkirFlat = 15000;
    public int $gratisOngkirMinimal = 250000;

    /** @var array<string, string> */
    public array $metodePembayaran = [
        'transfer_bca' => 'Transfer Bank BCA',
        'qris'         => 'QRIS (Instan)',
        'cod'          => 'Bayar di Tempat (COD)',
    ];

    /** @var array<string, string> */
    public array $daftarStatus = [
        'pending'    => 'Menunggu Pembayaran',
        'diproses'   => 'Sedang Diproses',
        'dikirim'    => 'Dalam Pengiriman',
        'selesai'    => 'Selesai',
        'dibatalkan' => 'Dibatalkan',
    ];
}

