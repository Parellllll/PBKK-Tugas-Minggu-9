<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class MahasiswaController extends BaseController
{
    private MahasiswaModel $mahasiswaModel;
    private string $uploadPath;

    public function __construct()
    {
        $this->mahasiswaModel = new MahasiswaModel();
        $this->uploadPath     = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'foto';
    }

    public function index(): string
    {
        $keyword = $this->request->getGet('q');
        $prodi   = $this->request->getGet('prodi');

        return view('admin/mahasiswa/index', [
            'title'       => 'Kelola Biodata Mahasiswa',
            'mahasiswa'   => $this->mahasiswaModel->filterAndPaginate($keyword, $prodi, 6),
            'pager'       => $this->mahasiswaModel->pager,
            'keyword'     => $keyword ?? '',
            'prodiAktif'  => $prodi ?? '',
            'daftarProdi' => MahasiswaModel::DAFTAR_PRODI,
        ]);
    }

    public function create(): string
    {
        return view('admin/mahasiswa/form', [
            'title'       => 'Tambah Biodata Mahasiswa',
            'mode'        => 'create',
            'mhs'         => null,
            'daftarProdi' => MahasiswaModel::DAFTAR_PRODI,
        ]);
    }

    public function store(): RedirectResponse
    {
        $data = $this->collectInput();

        $this->mahasiswaModel->setValidationRule(
            'nrp',
            'required|numeric|min_length[8]|max_length[20]|is_unique[mahasiswa.nrp]'
        );

        $fotoFile = $this->request->getFile('foto');
        $fotoError = $this->validatePhoto($fotoFile);
        if ($fotoError !== null) {
            return redirect()->back()->withInput()->with('errors', ['foto' => $fotoError]);
        }

        if (! $this->mahasiswaModel->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $this->mahasiswaModel->errors());
        }

        if ($fotoFile && $fotoFile->isValid() && ! $fotoFile->hasMoved()) {
            $data['foto'] = $this->storePhoto($fotoFile);
        }

        $this->mahasiswaModel->skipValidation(true)->insert($data);

        return redirect()->to('/admin/mahasiswa')->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function edit(int $id): string
    {
        $mhs = $this->mahasiswaModel->find($id);
        if (! $mhs) {
            throw PageNotFoundException::forPageNotFound('Data mahasiswa tidak ditemukan.');
        }

        return view('admin/mahasiswa/form', [
            'title'       => 'Edit Biodata: ' . $mhs['nama'],
            'mode'        => 'edit',
            'mhs'         => $mhs,
            'daftarProdi' => MahasiswaModel::DAFTAR_PRODI,
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        $mhs = $this->mahasiswaModel->find($id);
        if (! $mhs) {
            throw PageNotFoundException::forPageNotFound('Data mahasiswa tidak ditemukan.');
        }

        $data = $this->collectInput();

        $this->mahasiswaModel->setValidationRule(
            'nrp',
            "required|numeric|min_length[8]|max_length[20]|is_unique[mahasiswa.nrp,id,{$id}]"
        );

        $fotoFile  = $this->request->getFile('foto');
        $fotoError = $this->validatePhoto($fotoFile);
        if ($fotoError !== null) {
            return redirect()->back()->withInput()->with('errors', ['foto' => $fotoError]);
        }

        if (! $this->mahasiswaModel->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $this->mahasiswaModel->errors());
        }

        if ($fotoFile && $fotoFile->isValid() && ! $fotoFile->hasMoved()) {
            $this->deletePhoto($mhs['foto'] ?? null);
            $data['foto'] = $this->storePhoto($fotoFile);
        }

        $this->mahasiswaModel->skipValidation(true)->update($id, $data);

        return redirect()->to('/admin/mahasiswa')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function delete(int $id): RedirectResponse
    {
        $mhs = $this->mahasiswaModel->find($id);
        if (! $mhs) {
            return redirect()->to('/admin/mahasiswa')->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $this->deletePhoto($mhs['foto'] ?? null);
        $this->mahasiswaModel->delete($id);

        return redirect()->to('/admin/mahasiswa')->with('success', 'Data mahasiswa "' . $mhs['nama'] . '" berhasil dihapus.');
    }

    private function collectInput(): array
    {
        return [
            'nrp'           => trim((string) $this->request->getPost('nrp')),
            'nama'          => trim((string) $this->request->getPost('nama')),
            'email'         => trim((string) $this->request->getPost('email')),
            'prodi'         => trim((string) $this->request->getPost('prodi')),
            'angkatan'      => (int) $this->request->getPost('angkatan'),
            'jenis_kelamin' => (string) $this->request->getPost('jenis_kelamin'),
            'no_hp'         => trim((string) $this->request->getPost('no_hp')),
            'alamat'        => trim((string) $this->request->getPost('alamat')),
            'ipk'           => (string) $this->request->getPost('ipk'),
        ];
    }

    private function validatePhoto($file): ?string
    {
        if (! $file || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if (! $file->isValid()) {
            return $file->getErrorString();
        }

        $rules = [
            'foto' => 'is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/webp]|max_size[foto,2048]',
        ];

        if (! $this->validate($rules)) {
            return $this->validator->getError('foto');
        }

        return null;
    }

    private function storePhoto($file): string
    {
        if (! is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0775, true);
        }

        $newName = $file->getRandomName();
        $file->move($this->uploadPath, $newName);

        return $newName;
    }

    private function deletePhoto(?string $filename): void
    {
        if ($filename && is_file($this->uploadPath . DIRECTORY_SEPARATOR . $filename)) {
            @unlink($this->uploadPath . DIRECTORY_SEPARATOR . $filename);
        }
    }
}

