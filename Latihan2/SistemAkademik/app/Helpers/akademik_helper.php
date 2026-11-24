<?php

use Config\Akademik;

if (! function_exists('konversi_nilai')) {
    /**
     * Mengonversi nilai angka (0-100) ke huruf mutu, bobot, dan status kelulusan.
     *
     * @return array{huruf: string, bobot: float, status: string}
     */
    function konversi_nilai(float $skor): array
    {
        $cfg = config(Akademik::class);
        foreach ($cfg->skalaNilai as $skala) {
            if ($skor >= $skala['min']) {
                return [
                    'huruf'  => $skala['huruf'],
                    'bobot'  => $skala['bobot'],
                    'status' => $skala['lulus'] ? 'lulus' : 'tidak_lulus',
                ];
            }
        }

        return ['huruf' => 'E', 'bobot' => 0.00, 'status' => 'tidak_lulus'];
    }
}

if (! function_exists('predikat_ipk')) {
    function predikat_ipk(float $ipk): string
    {
        return match (true) {
            $ipk >= 3.51 => 'Dengan Pujian (Cum Laude)',
            $ipk >= 3.01 => 'Sangat Memuaskan',
            $ipk >= 2.76 => 'Memuaskan',
            $ipk >= 2.00 => 'Cukup',
            default      => 'Perlu Pembinaan',
        };
    }
}

if (! function_exists('badge_nilai')) {
    function badge_nilai(?string $huruf): string
    {
        return match ($huruf) {
            'A', 'AB' => 'bg-success',
            'B', 'BC' => 'bg-primary',
            'C'       => 'bg-warning text-dark',
            'D', 'E'  => 'bg-danger',
            default   => 'bg-secondary',
        };
    }
}

if (! function_exists('nama_dosen_lengkap')) {
    function nama_dosen_lengkap(array $dosen): string
    {
        $parts = [];
        if (! empty($dosen['gelar_depan'])) {
            $parts[] = trim($dosen['gelar_depan']);
        }
        $parts[] = trim($dosen['nama'] ?? '');
        $nama    = implode(' ', $parts);
        if (! empty($dosen['gelar_belakang'])) {
            $nama .= ', ' . trim($dosen['gelar_belakang']);
        }

        return $nama;
    }
}

