<?php

namespace App\Services;

class CryptoService
{
    private $key;
    private $cipher = 'AES-256-CBC';

    public function __construct()
    {
        $this->key = config('app.key');
    }

    public function encrypt($data)
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher));
        $encrypted = openssl_encrypt($data, $this->cipher, $this->key, 0, $iv);
        
        return base64_encode($iv . $encrypted);
    }

    public function decrypt($data)
    {
        $data = base64_decode($data);
        $ivLength = openssl_cipher_iv_length($this->cipher);
        $iv = substr($data, 0, $ivLength);
        $encrypted = substr($data, $ivLength);
        
        return openssl_decrypt($encrypted, $this->cipher, $this->key, 0, $iv);
    }
} 