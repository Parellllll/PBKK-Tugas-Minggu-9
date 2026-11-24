<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TokoSeeder extends Seeder
{
    public function run(): void
    {
        $now = date('Y-m-d H:i:s');

        $this->db->table('users')->insertBatch([
            [
                'id'             => 1,
                'username'       => 'admin',
                'nama_lengkap'   => 'Admin TokoKita',
                'email'          => 'admin@tokokita.id',
                'password_hash'  => password_hash('admin123', PASSWORD_DEFAULT),
                'role'           => 'admin',
                'no_hp'          => '081100001111',
                'alamat_default' => 'Jl. Teknik Kimia, Keputih, Surabaya',
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'id'             => 2,
                'username'       => 'farrel',
                'nama_lengkap'   => 'Farrel Prastita Ramaddhan',
                'email'          => 'farrel@student.its.ac.id',
                'password_hash'  => password_hash('user123', PASSWORD_DEFAULT),
                'role'           => 'customer',
                'no_hp'          => '081234567890',
                'alamat_default' => 'Keputih Tegal Timur No. 19, Sukolilo, Surabaya',
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'id'             => 3,
                'username'       => 'pelanggan',
                'nama_lengkap'   => 'Nadia Putri Kusuma',
                'email'          => 'nadia@student.its.ac.id',
                'password_hash'  => password_hash('user123', PASSWORD_DEFAULT),
                'role'           => 'customer',
                'no_hp'          => '081298765432',
                'alamat_default' => 'Gebang Putih No. 8, Sukolilo, Surabaya',
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
        ]);

        $this->db->table('kategori')->insertBatch([
            ['id' => 1, 'nama' => 'Periferal & Keyboard', 'slug' => 'periferal-keyboard', 'deskripsi' => 'Keyboard mekanikal, mouse wireless, dan aksesori meja kerja.'],
            ['id' => 2, 'nama' => 'Audio & Headset',      'slug' => 'audio-headset',      'deskripsi' => 'Headset gaming, TWS, dan mikrofon kondensor untuk kuliah daring.'],
            ['id' => 3, 'nama' => 'Penyimpanan & Kabel',  'slug' => 'penyimpanan-kabel',  'deskripsi' => 'SSD NVMe, flashdisk USB-C, dan USB Hub multifungsi.'],
            ['id' => 4, 'nama' => 'Buku & Merch Kampus',  'slug' => 'buku-merch-kampus',  'deskripsi' => 'Buku referensi pemrograman, hoodie, dan tumbler mahasiswa.'],
        ]);

        $this->db->table('produk')->insertBatch([
            ['id' => 1,  'kategori_id' => 1, 'kode' => 'PRD-001', 'nama' => 'Mechanical Keyboard 75% Hot-Swap',     'slug' => 'mechanical-keyboard-75-hot-swap',   'deskripsi' => 'Keyboard mekanikal 75% dengan gasket mount, switch linear tactile, koneksi USB-C & Bluetooth 5.0.', 'harga' => 549000, 'stok' => 15, 'gambar' => null, 'is_aktif' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2,  'kategori_id' => 1, 'kode' => 'PRD-002', 'nama' => 'Mouse Wireless Ergonomis 4000 DPI',    'slug' => 'mouse-wireless-ergonomis-4000-dpi', 'deskripsi' => 'Mouse dual-mode (2.4GHz + Bluetooth), klik senyap, baterai isi ulang USB-C tahan hingga 60 hari.',  'harga' => 215000, 'stok' => 24, 'gambar' => null, 'is_aktif' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3,  'kategori_id' => 1, 'kode' => 'PRD-003', 'nama' => 'Deskmat Wool Felt 90x40cm',            'slug' => 'deskmat-wool-felt-90x40cm',         'deskripsi' => 'Alas meja kerja minimalis anti-slip untuk setup laptop dan keyboard mekanikal.',                     'harga' => 119000, 'stok' => 30, 'gambar' => null, 'is_aktif' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4,  'kategori_id' => 2, 'kode' => 'PRD-004', 'nama' => 'Headset Studio Monitoring Over-Ear',   'slug' => 'headset-studio-monitoring',         'deskripsi' => 'Driver 50mm suara jernih, bantalan memory foam nyaman dipakai berjam-jam saat ngoding.',             'harga' => 385000, 'stok' => 12, 'gambar' => null, 'is_aktif' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5,  'kategori_id' => 2, 'kode' => 'PRD-005', 'nama' => 'TWS Low-Latency ANC Bluetooth 5.3',    'slug' => 'tws-low-latency-anc-bt53',          'deskripsi' => 'Active Noise Cancellation hingga 35dB, daya tahan baterai total 28 jam dengan charging case.',       'harga' => 299000, 'stok' => 18, 'gambar' => null, 'is_aktif' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 6,  'kategori_id' => 3, 'kode' => 'PRD-006', 'nama' => 'SSD Eksternal NVMe 1TB USB 3.2',       'slug' => 'ssd-eksternal-nvme-1tb',            'deskripsi' => 'Kecepatan baca hingga 1050 MB/s, bodi aluminium kompak tahan guncangan.',                            'harga' => 1150000,'stok' => 8,  'gambar' => null, 'is_aktif' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 7,  'kategori_id' => 3, 'kode' => 'PRD-007', 'nama' => 'USB-C Hub 8-in-1 HDMI 4K + PD 100W',   'slug' => 'usb-c-hub-8-in-1-hdmi-pd100w',      'deskripsi' => 'Dilengkapi HDMI 4K, Gigabit LAN, SD/TF Reader, 3x USB 3.0, dan Power Delivery 100W.',               'harga' => 265000, 'stok' => 20, 'gambar' => null, 'is_aktif' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 8,  'kategori_id' => 4, 'kode' => 'PRD-008', 'nama' => 'Buku Clean Architecture & Design',     'slug' => 'buku-clean-architecture-design',    'deskripsi' => 'Panduan praktis perancangan arsitektur perangkat lunak modern dan pola desain MVC.',                'harga' => 175000, 'stok' => 22, 'gambar' => null, 'is_aktif' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 9,  'kategori_id' => 4, 'kode' => 'PRD-009', 'nama' => 'Tumbler Stainless Insulated 600ml',    'slug' => 'tumbler-stainless-600ml',           'deskripsi' => 'Menjaga minuman dingin hingga 18 jam dan panas hingga 10 jam, bebas BPA.',                          'harga' => 135000, 'stok' => 25, 'gambar' => null, 'is_aktif' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 10, 'kategori_id' => 1, 'kode' => 'PRD-010', 'nama' => 'Laptop Stand Aluminium Lipat',         'slug' => 'laptop-stand-aluminium-lipat',      'deskripsi' => 'Stand ergonomis 6 tingkat ketinggian, membantu sirkulasi panas laptop hingga 16 inci.',             'harga' => 145000, 'stok' => 3,  'gambar' => null, 'is_aktif' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Contoh 1 pesanan selesai supaya riwayat pesanan, subquery terlaris, dan statistik admin langsung terisi
        $this->db->table('pesanan')->insert([
            'id'                => 1,
            'kode_invoice'      => 'INV-20261120-DEMO01',
            'user_id'           => 2,
            'nama_penerima'     => 'Farrel Prastita Ramaddhan',
            'no_hp'             => '081234567890',
            'alamat_pengiriman' => 'Keputih Tegal Timur No. 19, Sukolilo, Surabaya',
            'metode_pembayaran' => 'qris',
            'ongkir'            => 0,
            'subtotal'          => 764000,
            'total'             => 764000,
            'status'            => 'selesai',
            'catatan'           => 'Titipkan di pos satpam jika sedang kuliah.',
            'created_at'        => $now,
            'updated_at'        => $now,
        ]);

        $this->db->table('detail_pesanan')->insertBatch([
            ['pesanan_id' => 1, 'produk_id' => 1, 'nama_produk_snapshot' => 'Mechanical Keyboard 75% Hot-Swap',  'harga_satuan' => 549000, 'qty' => 1, 'subtotal' => 549000],
            ['pesanan_id' => 1, 'produk_id' => 2, 'nama_produk_snapshot' => 'Mouse Wireless Ergonomis 4000 DPI', 'harga_satuan' => 215000, 'qty' => 1, 'subtotal' => 215000],
        ]);
    }
}

