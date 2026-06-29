<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Kuis;
use App\Models\DetailKuis;
use App\Models\JumlahSoal;
use App\Models\Siswa;
use App\Models\JawabanSiswa;
use App\Models\PerolehanNilai;


class KuisController extends Controller
{
    // =========================
    // GET DATA KUIS
    // =========================
    public function index()
    {
        $kuis = Kuis::with('detailKuis')
            ->where('status', 'aktif')
            ->get();

        $formatted = [];

        foreach ($kuis as $item) {

            foreach ($item->detailKuis as $detail) {

                $formatted[] = [

                    'id_detail_kuis' =>
                        $detail->id_detail_kuis,

                    'q' =>
                        $detail->pertanyaan,

                    'options' => [
                        $detail->pilihan_a,
                        $detail->pilihan_b,
                        $detail->pilihan_c,
                        $detail->pilihan_d,
                    ],

                    'answer' => match ($detail->jawaban) {
                        'A' => 0,
                        'B' => 1,
                        'C' => 2,
                        'D' => 3,
                    },

                    'poin' =>
                        $detail->poin,

                    'judul_kuis' =>
                        $item->judul,
                ];
            }
        }

        return response()->json($formatted);
    }

    public function soalByKuis($id)
{
    $setting = JumlahSoal::first();

$jmlSoal = $setting
    ? $setting->jml_soal
    : null;

$query = DetailKuis::where(
    'id_kuis',
    $id
)->inRandomOrder();

if ($jmlSoal) {
    $query->limit($jmlSoal);
}

    $soal = $query->get()
        ->map(function ($item) {

            return [
                'id_detail_kuis' => $item->id_detail_kuis,
                'q' => $item->pertanyaan,
                'options' => [
                    $item->pilihan_a,
                    $item->pilihan_b,
                    $item->pilihan_c,
                    $item->pilihan_d,
                ],
                'answer' => $item->jawaban,
                'poin' => $item->poin,
            ];
        });

    return response()->json($soal);
}

public function listKuis()
{
    return Kuis::select(
        'id_kuis',
        'judul',
        'deskripsi'
    )
    ->where('status', 'aktif')
    ->get();
}

    // =========================
    // DATA KUIS ADMIN
    // =========================
    public function adminIndex()
    {
        $kuis = Kuis::with('detailKuis')
            ->orderBy('id_kuis', 'desc')
            ->get();

        return response()->json($kuis);
    }

    // =========================
    // TAMBAH KUIS
    // =========================
    public function store(Request $request)
{
    $request->validate([
        'judul' => 'required',
        'status' => 'required',

        'soal' => 'required|array|min:1',

        'soal.*.pertanyaan' => 'required',
        'soal.*.pilihan.A' => 'required',
        'soal.*.pilihan.B' => 'required',
        'soal.*.pilihan.C' => 'required',
        'soal.*.pilihan.D' => 'required',
        'soal.*.jawaban' => 'required',
    ], [
        'soal.*.pertanyaan.required' =>
            'Pertanyaan tidak boleh kosong.',

        'soal.*.pilihan.A.required' =>
            'Pilihan A tidak boleh kosong.',

        'soal.*.pilihan.B.required' =>
            'Pilihan B tidak boleh kosong.',

        'soal.*.pilihan.C.required' =>
            'Pilihan C tidak boleh kosong.',

        'soal.*.pilihan.D.required' =>
            'Pilihan D tidak boleh kosong.',

        'soal.*.jawaban.required' =>
            'Jawaban benar harus dipilih.',
    ]);

    // =========================
    // SIMPAN KUIS
    // =========================
    $kuis = Kuis::create([

        // sementara hardcode
        'id_guru' => 1,

        'judul' =>
            $request->judul,

        'deskripsi' =>
            $request->deskripsi,

        'status' =>
            $request->status,

        'tanggal_dibuat' =>
            now(),

        'total_soal' =>
            count($request->soal),
    ]);

    // =========================
    // BUAT RECORD JUMLAH SOAL
    // =========================


    // =========================
    // SIMPAN DETAIL SOAL
    // =========================
    foreach ($request->soal as $s) {

        DetailKuis::create([

            'id_kuis' =>
                $kuis->id_kuis,

            'pertanyaan' =>
                $s['pertanyaan'],

            'pilihan_a' =>
                $s['pilihan']['A'],

            'pilihan_b' =>
                $s['pilihan']['B'],

            'pilihan_c' =>
                $s['pilihan']['C'],

            'pilihan_d' =>
                $s['pilihan']['D'],

            'jawaban' =>
                $s['jawaban'],

            'poin' => 10,
        ]);
    }

    return response()->json([
        'message' =>
            'Kuis berhasil ditambahkan',

        'data' => $kuis
    ], 201);
}
    // =========================
    // DETAIL KUIS
    // =========================
    public function show($id)
    {
        $kuis = Kuis::with('detailKuis')
            ->findOrFail($id);

        return response()->json($kuis);
    }

    // =========================
    // UPDATE KUIS
    // =========================
    public function update(Request $request, $id)
    {
        $kuis = Kuis::findOrFail($id);
        $request->validate([
            'judul' => 'required',
            'status' => 'required',
            'soal' => 'required|array|min:1',
        ]);
        // UPDATE KUIS
        $kuis->update([

            'judul' =>
                $request->judul,

            'deskripsi' =>
                $request->deskripsi,

            'status' =>
                $request->status,

            'total_soal' =>
                count($request->soal),
        ]);

        // HAPUS SOAL LAMA
        DetailKuis::where(
            'id_kuis',
            $id
        )->delete();

        // INSERT SOAL BARU
        foreach ($request->soal as $soal) {

            DetailKuis::create([

                'id_kuis' =>
                    $id,

                'pertanyaan' =>
                    $soal['pertanyaan'],

                'pilihan_a' =>
                    $soal['pilihan']['A'],

                'pilihan_b' =>
                    $soal['pilihan']['B'],

                'pilihan_c' =>
                    $soal['pilihan']['C'],

                'pilihan_d' =>
                    $soal['pilihan']['D'],

                'jawaban' =>
                    $soal['jawaban'],

                'poin' => 10,
            ]);
        }

        return response()->json([
            'message' =>
                'Kuis berhasil diupdate'
        ]);
    }

    // =========================
    // DELETE KUIS
    // =========================
    public function destroy($id)
    {
        $kuis = Kuis::findOrFail($id);

        $kuis->delete();

        return response()->json([
            'message' =>
                'Kuis berhasil dihapus'
        ]);
    }



    public function updateJumlahSoal(Request $request, $idKuis)
{
    $totalSoal = DetailKuis::where(
        'id_kuis',
        $idKuis
    )->count();

    $request->validate([
        'jml_soal' => [
            'required',
            'integer',
            'min:1',
            'max:' . $totalSoal
        ]
    ]);

    }
    // =========================
// SUBMIT KUIS SISWA
// =========================
public function submitQuiz(Request $request)
{
    $request->validate([
        'id_siswa' => 'required',
        'jawaban' => 'required|array'
    ]);

    $jumlahBenar = 0;
    $jumlahSoal = count($request->jawaban);

    $detail = null;

    foreach ($request->jawaban as $item) {

        // =========================
        // AMBIL DETAIL SOAL
        // =========================
        $detail = DetailKuis::find(
            $item['id_detail_kuis']
        );

        if (!$detail) {
            continue;
        }

        // =========================
        // CEK BENAR / SALAH
        // =========================
        $point = 0;

        if (
            $item['jawaban_siswa']
            ==
            $detail->jawaban
        ) {

            $jumlahBenar++;

            $point = 10;
        }

        // =========================
        // SIMPAN JAWABAN SISWA
        // =========================
        $jawabanSiswa =
            JawabanSiswa::create([

                'id_detail_kuis' =>
                    $detail->id_detail_kuis,

                'id_siswa' =>
                    $request->id_siswa,

                'jawaban_siswa' =>
                    $item['jawaban_siswa'],

                'perolehan_point' =>
                    $point,
            ]);
    }

    // =========================
    // HITUNG NILAI
    // =========================
    $setting = JumlahSoal::first();

    $jmlSoal = $setting ? $setting->jml_soal : 0;

    $nilai = 0;

    if ($jmlSoal > 0) {

        $nilai = round(
            ($jumlahBenar / $jmlSoal) * 100,
            2
        );
    }

    // =========================
    // AMBIL JAWABAN TERAKHIR
    // =========================
    $jawabanTerakhir = JawabanSiswa::where('id_siswa', $request->id_siswa)
    ->latest()
    ->first();

    // =========================
    // SIMPAN NILAI
    // =========================
    if ($detail && $jawabanTerakhir) {

        PerolehanNilai::create([

            'id_siswa' =>
                $request->id_siswa,

            'id_kuis' =>
                $detail->id_kuis,

            'id_jawaban_siswa' =>
                $jawabanTerakhir->id_jawaban_siswa,

            'total_nilai' =>
                $nilai,
        ]);
    }


  // =========================
// RESPONSE DEBUG
// =========================
return response()->json([

    'message' =>
        'Kuis selesai',

    'nilai' =>
        $nilai,

    'jumlah_benar' =>
        $jumlahBenar,

    'jumlah_soal' =>
        $jumlahSoal,

    'jawaban_diterima' =>
        $request->jawaban
]);
}}
