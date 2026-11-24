<?php

namespace App\Controllers;

use App\Models\UserModel;

class ProfilController extends BaseController
{
    public function index(): string
    {
        $userModel = new UserModel();
        $user      = $userModel->find(session()->get('user_id'));

        return view('profil/index', [
            'title' => 'Profil Pengguna',
            'user'  => $user,
        ]);
    }
}

