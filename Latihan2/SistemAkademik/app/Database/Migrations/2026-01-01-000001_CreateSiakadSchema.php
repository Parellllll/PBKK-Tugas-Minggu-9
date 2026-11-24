<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSiakadSchema extends Migration
{
    public function up(): void
    {
        // 1. users
        $this->forge->addField([
            'id'            => ['type' => 'INTEGER', 'unsigned' => true, 'auto_increment' => true],
            'username'      => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'nama_lengkap'  => ['type' => 'VARCHAR', 'constraint' => 120],
            'email'         => ['type' => 'VARCHAR', 'constraint' => 120, 'unique' => true],
            'password_hash' => ['type' => 'VARCHAR', 'constraint' => 255],
            'role'          => ['type' => 'VARCHAR', 'constraint' => 20], // admin | dosen | mahasiswa
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users', true);

        // 2. prodi
        $this->forge->addField([
            'id'       => ['type' => 'INTEGER', 'unsigned' => true, 'auto_increment' => true],
            'kode'     => ['type' => 'VARCHAR', 'constraint' => 15, 'unique' => true],
            'nama'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'fakultas' => ['type' => 'VARCHAR', 'constraint' => 120],
            'jenjang'  => ['type' => 'VARCHAR', 'constraint' => 10, 'default' => 'S1'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('prodi', true);

        // 3. tahun_akademik
        $this->forge->addField([
            'id'       => ['type' => 'INTEGER', 'unsigned' => true, 'auto_increment' => true],
            'kode'     => ['type' => 'VARCHAR', 'constraint' => 15, 'unique' => true],
            'nama'     => ['type' => 'VARCHAR', 'constraint' => 80],
            'semester' => ['type' => 'VARCHAR', 'constraint' => 10], // Ganjil | Genap
            'is_aktif' => ['type' => 'INTEGER', 'constraint' => 1, 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tahun_akademik', true);

        // 4. dosen
        $this->forge->addField([
            'id'             => ['type' => 'INTEGER', 'unsigned' => true, 'auto_increment' => true],
            'user_id'        => ['type' => 'INTEGER', 'unsigned' => true, 'unique' => true],
            'prodi_id'       => ['type' => 'INTEGER', 'unsigned' => true],
            'nidn'           => ['type' => 'VARCHAR', 'constraint' => 25, 'unique' => true],
            'nama'           => ['type' => 'VARCHAR', 'constraint' => 120],
            'gelar_depan'    => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'gelar_belakang' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'email'          => ['type' => 'VARCHAR', 'constraint' => 120],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('prodi_id', 'prodi', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('dosen', true);

        // 5. mahasiswa
        $this->forge->addField([
            'id'       => ['type' => 'INTEGER', 'unsigned' => true, 'auto_increment' => true],
            'user_id'  => ['type' => 'INTEGER', 'unsigned' => true, 'unique' => true],
            'prodi_id' => ['type' => 'INTEGER', 'unsigned' => true],
            'nrp'      => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'nama'     => ['type' => 'VARCHAR', 'constraint' => 120],
            'angkatan' => ['type' => 'INTEGER', 'constraint' => 4],
            'status'   => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'aktif'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('prodi_id', 'prodi', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('mahasiswa', true);

        // 6. mata_kuliah
        $this->forge->addField([
            'id'             => ['type' => 'INTEGER', 'unsigned' => true, 'auto_increment' => true],
            'prodi_id'       => ['type' => 'INTEGER', 'unsigned' => true],
            'kode'           => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'nama'           => ['type' => 'VARCHAR', 'constraint' => 120],
            'sks'            => ['type' => 'INTEGER', 'constraint' => 2],
            'semester_paket' => ['type' => 'INTEGER', 'constraint' => 2, 'default' => 1],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('prodi_id', 'prodi', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('mata_kuliah', true);

        // 7. kelas
        $this->forge->addField([
            'id'                => ['type' => 'INTEGER', 'unsigned' => true, 'auto_increment' => true],
            'mata_kuliah_id'    => ['type' => 'INTEGER', 'unsigned' => true],
            'dosen_id'          => ['type' => 'INTEGER', 'unsigned' => true],
            'tahun_akademik_id' => ['type' => 'INTEGER', 'unsigned' => true],
            'nama_kelas'        => ['type' => 'VARCHAR', 'constraint' => 20],
            'jadwal'            => ['type' => 'VARCHAR', 'constraint' => 80],
            'ruangan'           => ['type' => 'VARCHAR', 'constraint' => 40],
            'kuota'             => ['type' => 'INTEGER', 'constraint' => 4, 'default' => 40],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('mata_kuliah_id', 'mata_kuliah', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('dosen_id', 'dosen', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('tahun_akademik_id', 'tahun_akademik', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kelas', true);

        // 8. krs
        $this->forge->addField([
            'id'                => ['type' => 'INTEGER', 'unsigned' => true, 'auto_increment' => true],
            'mahasiswa_id'      => ['type' => 'INTEGER', 'unsigned' => true],
            'kelas_id'          => ['type' => 'INTEGER', 'unsigned' => true],
            'tahun_akademik_id' => ['type' => 'INTEGER', 'unsigned' => true],
            'nilai_angka'       => ['type' => 'DECIMAL', 'constraint' => '5,2', 'null' => true],
            'nilai_huruf'       => ['type' => 'VARCHAR', 'constraint' => 3, 'null' => true],
            'bobot'             => ['type' => 'DECIMAL', 'constraint' => '3,2', 'null' => true],
            'status'            => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'diambil'],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['mahasiswa_id', 'kelas_id']);
        $this->forge->addForeignKey('mahasiswa_id', 'mahasiswa', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kelas_id', 'kelas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tahun_akademik_id', 'tahun_akademik', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('krs', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('krs', true);
        $this->forge->dropTable('kelas', true);
        $this->forge->dropTable('mata_kuliah', true);
        $this->forge->dropTable('mahasiswa', true);
        $this->forge->dropTable('dosen', true);
        $this->forge->dropTable('tahun_akademik', true);
        $this->forge->dropTable('prodi', true);
        $this->forge->dropTable('users', true);
    }
}

