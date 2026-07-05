<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required'
        ],
         [
        'login.required' => 'Username wajib diisi.',
        'password.required' => 'Password wajib diisi.',
        ]
        );

        $guru = DB::table('tb_guru')
            ->where('username', $request->login)
            ->first();

        if (!$guru) {
            return response()->json([
                'success' => false,
                'message' => 'Username tidak ditemukan'
            ], 401);
        }

        if (!Hash::check($request->password, $guru->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password salah'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'user' => $guru
        ]);
    }
}
