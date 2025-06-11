<?php

namespace App\Http\Controllers;

use App\Services\CryptoService;
use Illuminate\Http\Request;

class CryptoDemoController extends Controller
{
    protected $cryptoService;

    public function __construct(CryptoService $cryptoService)
    {
        $this->cryptoService = $cryptoService;
    }

    public function index()
    {
        return view('crypto.demo');
    }

    public function encrypt(Request $request)
    {
        $request->validate([
            'text' => 'required|string'
        ]);

        $encrypted = $this->cryptoService->encrypt($request->text);
        
        return response()->json([
            'encrypted' => $encrypted,
            'decrypted' => $this->cryptoService->decrypt($encrypted)
        ]);
    }
} 