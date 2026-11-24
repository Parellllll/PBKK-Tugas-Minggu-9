<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTokoSchema extends Migration
{
    public function up(): void
    {
        // 1. users
        $this->forge->addField([
            'id'             => ['type' => 'INTEGER', 'unsigned' => true, 'auto_increment' => true],
            'username'       => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'nama_lengkap'   => ['type' => 'VARCHAR', 'constraint' => 120],
            'email'          => ['type' => 'VARCHAR', 'constraint' => 120, 'unique' => true],
            'password_hash'  => ['type' => 'VARCHAR', 'constraint' => 255],
            'role'           => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'customer'],
            'no_hp'          => ['type' => 'VARCHAR', 'constraint' => 25, 'null' => true],
            'alamat_default' => ['type' => 'TEXT', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users', true);

        // 2. kategori
        $this->forge->addField([
            'id'        => ['type' => 'INTEGER', 'unsigned' => true, 'auto_increment' => true],
            'nama'      => ['type' => 'VARCHAR', 'constraint' => 80],
            'slug'      => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
            'deskripsi' => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kategori', true);

        // 3. produk
        $this->forge->addField([
            'id'          => ['type' => 'INTEGER', 'unsigned' => true, 'auto_increment' => true],
            'kategori_id' => ['type' => 'INTEGER', 'unsigned' => true],
            'kode'        => ['type' => 'VARCHAR', 'constraint' => 30, 'unique' => true],
            'nama'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 180, 'unique' => true],
            'deskripsi'   => ['type' => 'TEXT', 'null' => true],
            'harga'       => ['type' => 'INTEGER', 'unsigned' => true],
            'stok'        => ['type' => 'INTEGER', 'unsigned' => true, 'default' => 0],
            'gambar'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'is_aktif'    => ['type' => 'INTEGER', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('kategori_id', 'kategori', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('produk', true);

        // 4. pesanan
        $this->forge->addField([
            'id'                => ['type' => 'INTEGER', 'unsigned' => true, 'auto_increment' => true],
            'kode_invoice'      => ['type' => 'VARCHAR', 'constraint' => 40, 'unique' => true],
            'user_id'           => ['type' => 'INTEGER', 'unsigned' => true],
            'nama_penerima'     => ['type' => 'VARCHAR', 'constraint' => 120],
            'no_hp'             => ['type' => 'VARCHAR', 'constraint' => 25],
            'alamat_pengiriman' => ['type' => 'TEXT'],
            'metode_pembayaran' => ['type' => 'VARCHAR', 'constraint' => 30],
            'ongkir'            => ['type' => 'INTEGER', 'unsigned' => true, 'default' => 0],
            'subtotal'          => ['type' => 'INTEGER', 'unsigned' => true],
            'total'             => ['type' => 'INTEGER', 'unsigned' => true],
            'status'            => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'pending'],
            'catatan'           => ['type' => 'TEXT', 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('pesanan', true);

        // 5. detail_pesanan
        $this->forge->addField([
            'id'                   => ['type' => 'INTEGER', 'unsigned' => true, 'auto_increment' => true],
            'pesanan_id'           => ['type' => 'INTEGER', 'unsigned' => true],
            'produk_id'            => ['type' => 'INTEGER', 'unsigned' => true],
            'nama_produk_snapshot' => ['type' => 'VARCHAR', 'constraint' => 150],
            'harga_satuan'         => ['type' => 'INTEGER', 'unsigned' => true],
            'qty'                  => ['type' => 'INTEGER', 'unsigned' => true],
            'subtotal'             => ['type' => 'INTEGER', 'unsigned' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pesanan_id', 'pesanan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('produk_id', 'produk', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('detail_pesanan', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('detail_pesanan', true);
        $this->forge->dropTable('pesanan', true);
        $this->forge->dropTable('produk', true);
        $this->forge->dropTable('kategori', true);
        $this->forge->dropTable('users', true);
    }
}

