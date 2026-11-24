<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriModel;
use App\Models\PesananModel;
use App\Models\ProdukModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function index(): string
    {
        $pesananModel = new PesananModel();
        $produkModel  = new ProdukModel();

        return view('admin/dashboard', [
            'title'          => 'Dashboard Admin TokoKita',
            'statistik'      => $pesananModel->getStatistik(),
            'totalProduk'    => $produkModel->countAllResults(),
            'totalKategori'  => (new KategoriModel())->countAllResults(),
            'totalCustomer'  => (new UserModel())->where('role', 'customer')->countAllResults(),
            'stokMenipis'    => $produkModel->where('stok <=', 5)->orderBy('stok', 'ASC')->findAll(5),
            'pesananTerbaru' => $pesananModel->getAllWithCustomer(),
        ]);
    }
}

