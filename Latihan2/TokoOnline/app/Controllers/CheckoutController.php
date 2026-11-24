<?php

namespace App\Controllers;

use App\Exceptions\EmptyCartException;
use App\Exceptions\InsufficientStockException;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;
use Config\Toko;

class CheckoutController extends BaseController
{
    public function index(): string|RedirectResponse
    {
        $cart = Services::cart();
        if ($cart->isEmpty()) {
            return redirect()->to('/keranjang')->with('error', 'Keranjang Anda kosong. Tambahkan produk sebelum checkout.');
        }

        $user = (new UserModel())->find((int) session()->get('user_id'));

        return view('store/checkout', [
            'title'      => 'Checkout Pesanan — TokoKita',
            'items'      => $cart->items(),
            'subtotal'   => $cart->subtotal(),
            'ongkir'     => $cart->ongkir(),
            'grandTotal' => $cart->grandTotal(),
            'user'       => $user,
            'tokoConfig' => config(Toko::class),
        ]);
    }

    public function proses(): RedirectResponse
    {
        $rules = [
            'nama_penerima'     => 'required|min_length[3]|max_length[120]',
            'no_hp'             => 'required|min_length[8]|max_length[25]',
            'alamat_pengiriman' => 'required|min_length[10]|max_length[500]',
            'metode_pembayaran' => 'required|in_list[transfer_bca,qris,cod]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $hasil = Services::checkout()->prosesCheckout((int) session()->get('user_id'), [
                'nama_penerima'     => $this->request->getPost('nama_penerima'),
                'no_hp'             => $this->request->getPost('no_hp'),
                'alamat_pengiriman' => $this->request->getPost('alamat_pengiriman'),
                'metode_pembayaran' => $this->request->getPost('metode_pembayaran'),
                'catatan'           => $this->request->getPost('catatan'),
            ]);

            return redirect()->to('/pesanan/' . $hasil['kode_invoice'])
                ->with('success', 'Pesanan ' . $hasil['kode_invoice'] . ' berhasil dibuat! Stok produk telah diperbarui.');
        } catch (EmptyCartException|InsufficientStockException $e) {
            return redirect()->to('/keranjang')->with('error', $e->getMessage());
        } catch (\Throwable $e) {
            log_message('error', 'Checkout gagal: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal memproses pesanan. Silakan coba kembali.');
        }
    }
}

