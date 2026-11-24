<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function index(): string
    {
        $mhsModel  = new MahasiswaModel();
        $userModel = new UserModel();

        return view('admin/dashboard', [
            'title'      => 'Dashboard Admin — SB Admin 2',
            'ringkasan'  => $mhsModel->getRingkasan(),
            'totalUsers' => $userModel->countAllResults(),
            'terbaru'    => $mhsModel->orderBy('id', 'DESC')->findAll(5),
        ]);
    }
}

