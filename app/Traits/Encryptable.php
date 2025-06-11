<?php

namespace App\Traits;

use App\Services\CryptoService;

trait Encryptable
{
    protected $cryptoService;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->cryptoService = app(CryptoService::class);
    }

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        
        if (in_array($key, $this->encryptable) && !is_null($value)) {
            try {
                return $this->cryptoService->decrypt($value);
            } catch (\Exception $e) {
                return $value;
            }
        }
        
        return $value;
    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encryptable) && !is_null($value)) {
            $value = $this->cryptoService->encrypt($value);
        }
        
        return parent::setAttribute($key, $value);
    }
} 