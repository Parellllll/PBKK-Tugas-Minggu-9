<?php

namespace App\Controllers\Dosen;

use App\Controllers\AbstractRoleController;
use App\Models\DosenModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseDosenController extends AbstractRoleController
{
    protected ?array $dosen = null;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger): void
    {
        parent::initController($request, $response, $logger);
        $this->dosen = (new DosenModel())->findByUserId((int) session()->get('user_id'));
    }

    protected function expectedRole(): string
    {
        return 'dosen';
    }
}

