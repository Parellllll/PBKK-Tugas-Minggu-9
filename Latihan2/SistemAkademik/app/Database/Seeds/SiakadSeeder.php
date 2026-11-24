<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SiakadSeeder extends Seeder
{
    public function run(): void
    {
        $now = date('Y-m-d H:i:s');

        // 1. Prodi
        $this->db->table('prodi')->insertBatch([
            ['id' => 1, 'kode' => 'IF',  'nama' => 'Teknik Informatika',            'fakultas' => 'FTEIC — ITS', 'jenjang' => 'S1'],
            ['id' => 2, 'kode' => 'RPL', 'nama' => 'Rekayasa Perangkat Lunak',      'fakultas' => 'FTEIC — ITS', 'jenjang' => 'S1'],
            ['id' => 3, 'kode' => 'RKA', 'nama' => 'Rekayasa Kecerdasan Artifisial','fakultas' => 'FTEIC — ITS', 'jenjang' => 'S1'],
        ]);

        // 2. Tahun Akademik
        $this->db->table('tahun_akademik')->insertBatch([
            ['id' => 1, 'kode' => '20242', 'nama' => '2024/2025 Genap',  'semester' => 'Genap',  'is_aktif' => 0],
            ['id' => 2, 'kode' => '20251', 'nama' => '2025/2026 Ganjil', 'semester' => 'Ganjil', 'is_aktif' => 1],
        ]);

        // 3. Users (Admin, 3 Dosen, 4 Mahasiswa)
        $this->db->table('users')->insertBatch([
            ['id' => 1, 'username' => 'admin',   'nama_lengkap' => 'Admin Akademik FTEIC',      'email' => 'admin@siakad.its.ac.id',           'password_hash' => password_hash('admin123', PASSWORD_DEFAULT), 'role' => 'admin',     'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'username' => 'dosen1',  'nama_lengkap' => 'Fajar Baskoro',             'email' => 'fajar@if.its.ac.id',               'password_hash' => password_hash('dosen123', PASSWORD_DEFAULT), 'role' => 'dosen',     'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'username' => 'dosen2',  'nama_lengkap' => 'Baskoro Adi Pratomo',       'email' => 'baskoro@if.its.ac.id',             'password_hash' => password_hash('dosen123', PASSWORD_DEFAULT), 'role' => 'dosen',     'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'username' => 'dosen3',  'nama_lengkap' => 'Ratih Nur Esti Anggraini',  'email' => 'ratih@if.its.ac.id',               'password_hash' => password_hash('dosen123', PASSWORD_DEFAULT), 'role' => 'dosen',     'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'username' => 'farrel',  'nama_lengkap' => 'Farrel Prastita Ramaddhan', 'email' => '5025241219@student.its.ac.id',     'password_hash' => password_hash('mhs123', PASSWORD_DEFAULT),   'role' => 'mahasiswa', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 6, 'username' => 'nadia',   'nama_lengkap' => 'Nadia Putri Kusuma',        'email' => '5025241001@student.its.ac.id',     'password_hash' => password_hash('mhs123', PASSWORD_DEFAULT),   'role' => 'mahasiswa', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 7, 'username' => 'raka',    'nama_lengkap' => 'Raka Mahendra Wijaya',      'email' => '5025241014@student.its.ac.id',     'password_hash' => password_hash('mhs123', PASSWORD_DEFAULT),   'role' => 'mahasiswa', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 8, 'username' => 'aisyah',  'nama_lengkap' => 'Siti Aisyah Rahmawati',     'email' => '5025241028@student.its.ac.id',     'password_hash' => password_hash('mhs123', PASSWORD_DEFAULT),   'role' => 'mahasiswa', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 4. Dosen
        $this->db->table('dosen')->insertBatch([
            ['id' => 1, 'user_id' => 2, 'prodi_id' => 1, 'nidn' => '0015047801', 'nama' => 'Fajar Baskoro',            'gelar_depan' => 'Dr.',     'gelar_belakang' => 'S.Kom., M.T.',    'email' => 'fajar@if.its.ac.id'],
            ['id' => 2, 'user_id' => 3, 'prodi_id' => 1, 'nidn' => '0021088502', 'nama' => 'Baskoro Adi Pratomo',      'gelar_depan' => 'Dr. Ir.', 'gelar_belakang' => 'S.Kom., M.Kom.',  'email' => 'baskoro@if.its.ac.id'],
            ['id' => 3, 'user_id' => 4, 'prodi_id' => 2, 'nidn' => '0010038903', 'nama' => 'Ratih Nur Esti Anggraini', 'gelar_depan' => '',        'gelar_belakang' => 'S.Kom., M.Sc., Ph.D.', 'email' => 'ratih@if.its.ac.id'],
        ]);

        // 5. Mahasiswa
        $this->db->table('mahasiswa')->insertBatch([
            ['id' => 1, 'user_id' => 5, 'prodi_id' => 1, 'nrp' => '5025241219', 'nama' => 'Farrel Prastita Ramaddhan', 'angkatan' => 2024, 'status' => 'aktif'],
            ['id' => 2, 'user_id' => 6, 'prodi_id' => 1, 'nrp' => '5025241001', 'nama' => 'Nadia Putri Kusuma',        'angkatan' => 2024, 'status' => 'aktif'],
            ['id' => 3, 'user_id' => 7, 'prodi_id' => 1, 'nrp' => '5025241014', 'nama' => 'Raka Mahendra Wijaya',      'angkatan' => 2024, 'status' => 'aktif'],
            ['id' => 4, 'user_id' => 8, 'prodi_id' => 2, 'nrp' => '5025241028', 'nama' => 'Siti Aisyah Rahmawati',     'angkatan' => 2024, 'status' => 'aktif'],
        ]);

        // 6. Mata Kuliah
        $this->db->table('mata_kuliah')->insertBatch([
            ['id' => 1, 'prodi_id' => 1, 'kode' => 'EF234101', 'nama' => 'Struktur Data',                         'sks' => 4, 'semester_paket' => 2],
            ['id' => 2, 'prodi_id' => 1, 'kode' => 'EF234102', 'nama' => 'Sistem Basis Data',                     'sks' => 3, 'semester_paket' => 2],
            ['id' => 3, 'prodi_id' => 1, 'kode' => 'EF234103', 'nama' => 'Organisasi Komputer',                   'sks' => 3, 'semester_paket' => 2],
            ['id' => 4, 'prodi_id' => 1, 'kode' => 'EF234201', 'nama' => 'Pemrograman Berbasis Kerangka Kerja',   'sks' => 3, 'semester_paket' => 3],
            ['id' => 5, 'prodi_id' => 1, 'kode' => 'EF234202', 'nama' => 'Pemrograman Berorientasi Objek',        'sks' => 3, 'semester_paket' => 3],
            ['id' => 6, 'prodi_id' => 1, 'kode' => 'EF234203', 'nama' => 'Jaringan Komputer',                     'sks' => 4, 'semester_paket' => 3],
            ['id' => 7, 'prodi_id' => 1, 'kode' => 'EF234204', 'nama' => 'Sistem Operasi',                        'sks' => 4, 'semester_paket' => 3],
            ['id' => 8, 'prodi_id' => 2, 'kode' => 'ER234205', 'nama' => 'Rekayasa Perangkat Lunak',              'sks' => 3, 'semester_paket' => 3],
        ]);

        // 7. Kelas (Semester lalu 20242 & Semester aktif 20251)
        $this->db->table('kelas')->insertBatch([
            // Semester 2024/2025 Genap (riwayat sudah bernilai)
            ['id' => 1, 'mata_kuliah_id' => 1, 'dosen_id' => 2, 'tahun_akademik_id' => 1, 'nama_kelas' => 'IF-D', 'jadwal' => 'Senin 08:00-10:30',  'ruangan' => 'IF-105', 'kuota' => 40],
            ['id' => 2, 'mata_kuliah_id' => 2, 'dosen_id' => 3, 'tahun_akademik_id' => 1, 'nama_kelas' => 'IF-D', 'jadwal' => 'Rabu 10:00-12:30',   'ruangan' => 'IF-106', 'kuota' => 40],
            ['id' => 3, 'mata_kuliah_id' => 3, 'dosen_id' => 2, 'tahun_akademik_id' => 1, 'nama_kelas' => 'IF-D', 'jadwal' => 'Kamis 13:00-15:30',  'ruangan' => 'IF-108', 'kuota' => 40],

            // Semester Aktif 2025/2026 Ganjil
            ['id' => 4, 'mata_kuliah_id' => 4, 'dosen_id' => 1, 'tahun_akademik_id' => 2, 'nama_kelas' => 'PBKK-D', 'jadwal' => 'Selasa 07:30-10:00', 'ruangan' => 'IF-103', 'kuota' => 40],
            ['id' => 5, 'mata_kuliah_id' => 5, 'dosen_id' => 1, 'tahun_akademik_id' => 2, 'nama_kelas' => 'PBO-D',  'jadwal' => 'Rabu 07:30-10:00',   'ruangan' => 'IF-104', 'kuota' => 40],
            ['id' => 6, 'mata_kuliah_id' => 6, 'dosen_id' => 2, 'tahun_akademik_id' => 2, 'nama_kelas' => 'JARKOM-D','jadwal' => 'Kamis 09:00-11:30', 'ruangan' => 'IF-105', 'kuota' => 35],
            ['id' => 7, 'mata_kuliah_id' => 7, 'dosen_id' => 2, 'tahun_akademik_id' => 2, 'nama_kelas' => 'SISOP-D', 'jadwal' => 'Jumat 08:00-10:30', 'ruangan' => 'IF-106', 'kuota' => 35],
            ['id' => 8, 'mata_kuliah_id' => 8, 'dosen_id' => 3, 'tahun_akademik_id' => 2, 'nama_kelas' => 'RPL-A',   'jadwal' => 'Senin 13:00-15:30', 'ruangan' => 'IF-107', 'kuota' => 30],
        ]);

        // 8. KRS (Riwayat bernilai semester 20242 + KRS aktif semester 20251)
        $this->db->table('krs')->insertBatch([
            // Riwayat Farrel (20242) -> IP = (4*4 + 3*3.5 + 3*4)/10 = 38.5 / 10 = 3.85
            ['mahasiswa_id' => 1, 'kelas_id' => 1, 'tahun_akademik_id' => 1, 'nilai_angka' => 90.00, 'nilai_huruf' => 'A',  'bobot' => 4.00, 'status' => 'lulus',   'created_at' => $now, 'updated_at' => $now],
            ['mahasiswa_id' => 1, 'kelas_id' => 2, 'tahun_akademik_id' => 1, 'nilai_angka' => 82.50, 'nilai_huruf' => 'AB', 'bobot' => 3.50, 'status' => 'lulus',   'created_at' => $now, 'updated_at' => $now],
            ['mahasiswa_id' => 1, 'kelas_id' => 3, 'tahun_akademik_id' => 1, 'nilai_angka' => 88.00, 'nilai_huruf' => 'A',  'bobot' => 4.00, 'status' => 'lulus',   'created_at' => $now, 'updated_at' => $now],

            // Riwayat Nadia (20242)
            ['mahasiswa_id' => 2, 'kelas_id' => 1, 'tahun_akademik_id' => 1, 'nilai_angka' => 92.00, 'nilai_huruf' => 'A',  'bobot' => 4.00, 'status' => 'lulus',   'created_at' => $now, 'updated_at' => $now],
            ['mahasiswa_id' => 2, 'kelas_id' => 2, 'tahun_akademik_id' => 1, 'nilai_angka' => 89.00, 'nilai_huruf' => 'A',  'bobot' => 4.00, 'status' => 'lulus',   'created_at' => $now, 'updated_at' => $now],

            // KRS Aktif Semester 20251 (PBKK-D & PBO-D untuk Farrel, Nadia, Raka)
            ['mahasiswa_id' => 1, 'kelas_id' => 4, 'tahun_akademik_id' => 2, 'nilai_angka' => null,  'nilai_huruf' => null, 'bobot' => null, 'status' => 'diambil', 'created_at' => $now, 'updated_at' => $now],
            ['mahasiswa_id' => 1, 'kelas_id' => 5, 'tahun_akademik_id' => 2, 'nilai_angka' => null,  'nilai_huruf' => null, 'bobot' => null, 'status' => 'diambil', 'created_at' => $now, 'updated_at' => $now],
            ['mahasiswa_id' => 2, 'kelas_id' => 4, 'tahun_akademik_id' => 2, 'nilai_angka' => 88.00, 'nilai_huruf' => 'A',  'bobot' => 4.00, 'status' => 'lulus',   'created_at' => $now, 'updated_at' => $now],
            ['mahasiswa_id' => 3, 'kelas_id' => 4, 'tahun_akademik_id' => 2, 'nilai_angka' => null,  'nilai_huruf' => null, 'bobot' => null, 'status' => 'diambil', 'created_at' => $now, 'updated_at' => $now],
            ['mahasiswa_id' => 4, 'kelas_id' => 8, 'tahun_akademik_id' => 2, 'nilai_angka' => null,  'nilai_huruf' => null, 'bobot' => null, 'status' => 'diambil', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}

