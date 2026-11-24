<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriModel;
use App\Models\ProdukModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class ProdukController extends BaseController
{
    private ProdukModel $produkModel;
    private string $uploadPath;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
        $this->uploadPath  = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'produk';
    }

    public function index(): string
    {
        $filters = ['q' => (string) ($this->request->getGet('q') ?? '')];

        return view('admin/produk/index', [
            'title'   => 'Kelola Produk TokoKita',
            'produk'  => $this->produkModel->filterKatalog($filters, 8, false),
            'pager'   => $this->produkModel->pager,
            'keyword' => $filters['q'],
        ]);
    }

    public function create(): string
    {
        return view('admin/produk/form', [
            'title'    => 'Tambah Produk Baru',
            'mode'     => 'create',
            'produk'   => null,
            'kategori' => (new KategoriModel())->orderBy('nama', 'ASC')->findAll(),
        ]);
    }

    public function store(): RedirectResponse
    {
        $nama = trim((string) $this->request->getPost('nama'));
        $slug = slugify_text($nama);

        $data = [
            'kategori_id' => (int) $this->request->getPost('kategori_id'),
            'kode'        => strtoupper(trim((string) $this->request->getPost('kode'))),
            'nama'        => $nama,
            'slug'        => $slug,
            'deskripsi'   => trim((string) $this->request->getPost('deskripsi')),
            'harga'       => (int) $this->request->getPost('harga'),
            'stok'        => (int) $this->request->getPost('stok'),
            'is_aktif'    => $this->request->getPost('is_aktif') ? 1 : 0,
        ];

        $this->produkModel->setValidationRule('kode', 'required|max_length[30]|is_unique[produk.kode]');
        $this->produkModel->setValidationRule('slug', 'required|max_length[180]|is_unique[produk.slug]');

        $gambarFile  = $this->request->getFile('gambar');
        $gambarError = $this->validateImage($gambarFile);
        if ($gambarError !== null) {
            return redirect()->back()->withInput()->with('errors', ['gambar' => $gambarError]);
        }

        if (! $this->produkModel->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $this->produkModel->errors());
        }

        if ($gambarFile && $gambarFile->isValid() && ! $gambarFile->hasMoved()) {
            $data['gambar'] = $this->storeImage($gambarFile);
        }

        $this->produkModel->skipValidation(true)->insert($data);

        return redirect()->to('/admin/produk')->with('success', 'Produk "' . $nama . '" berhasil ditambahkan.');
    }

    public function edit(int $id): string
    {
        $produk = $this->produkModel->find($id);
        if (! $produk) {
            throw PageNotFoundException::forPageNotFound('Produk tidak ditemukan.');
        }

        return view('admin/produk/form', [
            'title'    => 'Edit Produk: ' . $produk['nama'],
            'mode'     => 'edit',
            'produk'   => $produk,
            'kategori' => (new KategoriModel())->orderBy('nama', 'ASC')->findAll(),
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        $produk = $this->produkModel->find($id);
        if (! $produk) {
            throw PageNotFoundException::forPageNotFound('Produk tidak ditemukan.');
        }

        $nama = trim((string) $this->request->getPost('nama'));
        $data = [
            'kategori_id' => (int) $this->request->getPost('kategori_id'),
            'kode'        => strtoupper(trim((string) $this->request->getPost('kode'))),
            'nama'        => $nama,
            'slug'        => slugify_text($nama),
            'deskripsi'   => trim((string) $this->request->getPost('deskripsi')),
            'harga'       => (int) $this->request->getPost('harga'),
            'stok'        => (int) $this->request->getPost('stok'),
            'is_aktif'    => $this->request->getPost('is_aktif') ? 1 : 0,
        ];

        $this->produkModel->setValidationRule('kode', "required|max_length[30]|is_unique[produk.kode,id,{$id}]");
        $this->produkModel->setValidationRule('slug', "required|max_length[180]|is_unique[produk.slug,id,{$id}]");

        $gambarFile  = $this->request->getFile('gambar');
        $gambarError = $this->validateImage($gambarFile);
        if ($gambarError !== null) {
            return redirect()->back()->withInput()->with('errors', ['gambar' => $gambarError]);
        }

        if (! $this->produkModel->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $this->produkModel->errors());
        }

        if ($gambarFile && $gambarFile->isValid() && ! $gambarFile->hasMoved()) {
            $this->deleteImage($produk['gambar'] ?? null);
            $data['gambar'] = $this->storeImage($gambarFile);
        }

        $this->produkModel->skipValidation(true)->update($id, $data);

        return redirect()->to('/admin/produk')->with('success', 'Produk berhasil diperbarui.');
    }

    public function delete(int $id): RedirectResponse
    {
        $produk = $this->produkModel->find($id);
        if (! $produk) {
            return redirect()->to('/admin/produk')->with('error', 'Produk tidak ditemukan.');
        }

        try {
            $this->produkModel->delete($id);
            $this->deleteImage($produk['gambar'] ?? null);
            return redirect()->to('/admin/produk')->with('success', 'Produk berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->to('/admin/produk')->with('error', 'Produk tidak dapat dihapus karena sudah tercatat pada riwayat pesanan. Nonaktifkan produk sebagai gantinya.');
        }
    }

    private function validateImage($file): ?string
    {
        if (! $file || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if (! $file->isValid()) {
            return $file->getErrorString();
        }

        if (! $this->validate(['gambar' => 'is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]|max_size[gambar,2048]'])) {
            return $this->validator->getError('gambar');
        }

        return null;
    }

    private function storeImage($file): string
    {
        if (! is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0775, true);
        }

        $newName = $file->getRandomName();
        $file->move($this->uploadPath, $newName);

        return $newName;
    }

    private function deleteImage(?string $filename): void
    {
        if ($filename && is_file($this->uploadPath . DIRECTORY_SEPARATOR . $filename)) {
            @unlink($this->uploadPath . DIRECTORY_SEPARATOR . $filename);
        }
    }
}

