<?php

namespace Config;

use App\Libraries\CartLibrary;
use App\Services\CheckoutService;
use CodeIgniter\Config\BaseService;

class Services extends BaseService
{
    public static function cart(bool $getShared = true): CartLibrary
    {
        if ($getShared) {
            return static::getSharedInstance('cart');
        }

        return new CartLibrary(service('session'), config(Toko::class));
    }

    public static function checkout(bool $getShared = true): CheckoutService
    {
        if ($getShared) {
            return static::getSharedInstance('checkout');
        }

        return new CheckoutService(static::cart(), config(Toko::class));
    }
}
