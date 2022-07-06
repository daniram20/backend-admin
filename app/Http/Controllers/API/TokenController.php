<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Token;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    
    public function index()
    {
        $dataToken = Token::all();
        return response()->json([
            'message' => 'Data Token',
            'data' => $dataToken
        ]);
    }

    public function store(Request $request)
    {
        $tokenaplikasi = new Token();

        $tokenaplikasi->token = $request->token;
        $tokenaplikasi->save();

        return response()->json([
            'message' => 'Token berhasil disimpan',
            'data' => $tokenaplikasi
        ]);
    }
}
