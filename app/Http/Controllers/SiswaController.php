<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    // =========================
    // GET DATA
    // =========================
        public function index()
        {
            return response()->json(
                Siswa::orderBy('id_siswa', 'desc')
                    ->get()
            );
        }

        public function siswaAktif()
        {
            return response()->json(
                Siswa::where('status_siswa', 'aktif')
                    ->orderBy('nama')
                    ->get()
            );
        }

    // =========================
    // TAMBAH DATA
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:tb_siswa,nis',
            'nama' => 'required',
        ]);

        $siswa = Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'status_siswa' => 'aktif',
        ]);

        return response()->json([
            'message' => 'Data berhasil ditambahkan',
            'data' => $siswa
        ], 201);
    }

    // =========================
    // UPDATE DATA
    // =========================
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nis' => 'required|unique:tb_siswa,nis,' . $id . ',id_siswa',
            'nama' => 'required',
            'status_siswa' => 'required'
        ]);

        $siswa->update([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'status_siswa' => $request->status_siswa,
        ]);

        return response()->json([
            'message' => 'Data berhasil diupdate',
            'data' => $siswa
        ]);
    }
    public function showByNis($nis)
{
    $siswa = Siswa::where('nis', $nis)
        ->where('status_siswa', 'aktif')
        ->first();

    if (!$siswa) {
        return response()->json([
            'message' => 'Siswa tidak ditemukan'
        ], 404);
    }

    return response()->json([
        'data' => $siswa
    ]);
}
}
