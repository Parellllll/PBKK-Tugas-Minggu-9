<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\AbstractRoleController;
use App\Models\MahasiswaModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseMahasiswaController extends AbstractRoleController
{
    protected ?array $mahasiswa = null;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger): void
    {
        parent::initController($request, $response, $logger);
        $this->mahasiswa = (new MahasiswaModel())->findByUserId((int) session()->get('user_id'));
    }

    protected function expectedRole(): string
    {
        return 'mahasiswa';
    }
}

