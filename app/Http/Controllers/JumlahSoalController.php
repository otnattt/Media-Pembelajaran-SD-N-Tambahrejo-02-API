<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JumlahSoal;

class JumlahSoalController extends Controller
{
   public function show()
{
    $data = JumlahSoal::first();

    return response()->json([
        'jml_soal' => $data ? $data->jml_soal : 5
    ]);
}

    public function update(Request $request)
{
    $request->validate([
        'jml_soal' => 'required|integer|min:1'
    ]);

    $data = JumlahSoal::first();

    if ($data) {

        $data->update([
            'jml_soal' => $request->jml_soal
        ]);

    } else {

        JumlahSoal::create([
            'jml_soal' => $request->jml_soal
        ]);

    }

    return response()->json([
        'message' => 'Berhasil diubah'
    ]);
}
}
