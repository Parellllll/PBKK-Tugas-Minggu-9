<?php

namespace App\Exceptions;

use RuntimeException;

class EmptyCartException extends RuntimeException
{
    public function __construct(string $message = 'Keranjang belanja Anda masih kosong.')
    {
        parent::__construct($message);
    }
}

