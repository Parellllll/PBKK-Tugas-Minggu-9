<?php

namespace App\Controllers;

use App\Models\TahunAkademikModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Akademik;
use Psr\Log\LoggerInterface;

abstract class AbstractRoleController extends BaseController
{
    protected $helpers = ['akademik'];
    protected Akademik $akademikConfig;
    protected ?array $tahunAktif = null;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger): void
    {
        parent::initController($request, $response, $logger);

        $this->akademikConfig = config(Akademik::class);
        $this->tahunAktif     = (new TahunAkademikModel())->getAktif();
    }

    abstract protected function expectedRole(): string;

    protected function renderView(string $viewName, array $data = []): string
    {
        $shared = [
            'roleAktif'      => $this->expectedRole(),
            'tahunAktif'     => $this->tahunAktif,
            'akademikConfig' => $this->akademikConfig,
        ];

        return view($viewName, array_merge($shared, $data));
    }
}

