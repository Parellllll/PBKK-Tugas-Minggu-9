<?php

namespace App\Controllers;

use App\Models\DetailPesananModel;
use App\Models\PesananModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Toko;

class PesananController extends BaseController
{
    public function index(): string
    {
        $pesanan = (new PesananModel())->getRiwayatUser((int) session()->get('user_id'));

        return view('store/pesanan_index', [
            'title'   => 'Riwayat Pesanan Saya — TokoKita',
            'pesanan' => $pesanan,
        ]);
    }

    public function detail(string $invoice): string
    {
        $pesanan = (new PesananModel())->findByInvoice($invoice);

        if (! $pesanan || ((int) $pesanan['user_id'] !== (int) session()->get('user_id') && session()->get('user_role') !== 'admin')) {
            throw PageNotFoundException::forPageNotFound('Invoice pesanan tidak ditemukan.');
        }

        return view('store/pesanan_detail', [
            'title'      => 'Invoice ' . $pesanan['kode_invoice'],
            'pesanan'    => $pesanan,
            'items'      => (new DetailPesananModel())->getByPesananId((int) $pesanan['id']),
            'tokoConfig' => config(Toko::class),
        ]);
    }
}

