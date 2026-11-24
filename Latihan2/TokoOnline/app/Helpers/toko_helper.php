<?php

use Config\Toko;

if (! function_exists('format_rupiah')) {
    function format_rupiah(int|float $nominal): string
    {
        return 'Rp ' . number_format((float) $nominal, 0, ',', '.');
    }
}

if (! function_exists('badge_status_pesanan')) {
    function badge_status_pesanan(string $status): string
    {
        return match ($status) {
            'pending'    => 'bg-warning text-dark',
            'diproses'   => 'bg-info text-dark',
            'dikirim'    => 'bg-primary',
            'selesai'    => 'bg-success',
            'dibatalkan' => 'bg-danger',
            default      => 'bg-secondary',
        };
    }
}

if (! function_exists('label_status_pesanan')) {
    function label_status_pesanan(string $status): string
    {
        $cfg = config(Toko::class);

        return $cfg->daftarStatus[$status] ?? ucfirst($status);
    }
}

if (! function_exists('slugify_text')) {
    function slugify_text(string $text): string
    {
        $slug = strtolower(trim($text));
        $slug = (string) preg_replace('/[^a-z0-9]+/', '-', $slug);

        return trim($slug, '-') ?: 'item-' . time();
    }
}

