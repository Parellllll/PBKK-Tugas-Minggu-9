<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Akademik extends BaseConfig
{
    public string $namaInstitusi = 'Institut Teknologi Sepuluh Nopember';
    public string $namaAplikasi  = 'SIAKAD — Sistem Informasi Akademik';
    public int $maxSksPerSemester = 24;

    /**
     * Skala konversi nilai angka ke huruf mutu dan bobot (skala ITS).
     *
     * @var list<array{min: float, huruf: string, bobot: float, lulus: bool}>
     */
    public array $skalaNilai = [
        ['min' => 86.0, 'huruf' => 'A',  'bobot' => 4.00, 'lulus' => true],
        ['min' => 76.0, 'huruf' => 'AB', 'bobot' => 3.50, 'lulus' => true],
        ['min' => 66.0, 'huruf' => 'B',  'bobot' => 3.00, 'lulus' => true],
        ['min' => 61.0, 'huruf' => 'BC', 'bobot' => 2.50, 'lulus' => true],
        ['min' => 56.0, 'huruf' => 'C',  'bobot' => 2.00, 'lulus' => true],
        ['min' => 41.0, 'huruf' => 'D',  'bobot' => 1.00, 'lulus' => false],
        ['min' => 0.0,  'huruf' => 'E',  'bobot' => 0.00, 'lulus' => false],
    ];
}

