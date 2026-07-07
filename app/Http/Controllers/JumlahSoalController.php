<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JumlahSoal;

class JumlahSoalController extends Controller
{
    public function show()
{
    return response()->json(
        JumlahSoal::first()
    );
}


public function update(Request $request)
{
    $request->validate([
        'jml_soal' => 'required|integer|min:1'
    ]);

    $data = JumlahSoal::first();

    if (!$data) {
        $data = JumlahSoal::create([
            'jml_soal' => $request->jml_soal
        ]);
    } else {
        $data->update([
            'jml_soal' => $request->jml_soal
        ]);
    }

    return response()->json([
        'message'=>'Berhasil diubah'
    ]);
}
}
