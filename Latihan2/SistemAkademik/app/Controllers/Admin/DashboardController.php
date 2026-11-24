<?php

namespace App\Controllers\Admin;

use App\Models\DosenModel;
use App\Models\KelasModel;
use App\Models\KrsModel;
use App\Models\MahasiswaModel;
use App\Models\MataKuliahModel;
use App\Models\ProdiModel;

class DashboardController extends BaseAdminController
{
    public function index(): string
    {
        $kelasModel = new KelasModel();

        return $this->renderView('admin/dashboard', [
            'title'           => 'Dashboard Admin SIAKAD',
            'totalProdi'      => (new ProdiModel())->countAllResults(),
            'totalDosen'      => (new DosenModel())->countAllResults(),
            'totalMahasiswa'  => (new MahasiswaModel())->countAllResults(),
            'totalMataKuliah' => (new MataKuliahModel())->countAllResults(),
            'totalKrs'        => (new KrsModel())->countAllResults(),
            'kelasAktif'      => $this->tahunAktif ? $kelasModel->getDaftarKelas((int) $this->tahunAktif['id']) : [],
        ]);
    }
}

