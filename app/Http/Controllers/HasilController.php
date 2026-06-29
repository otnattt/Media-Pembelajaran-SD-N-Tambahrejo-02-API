<?php

namespace App\Http\Controllers;

use App\Models\PerolehanNilai;
use App\Exports\HasilExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class HasilController extends Controller
{
 public function exportExcel()
{
    return Excel::download(
        new HasilExport(),
        'hasil_penilaian.xlsx'
    );
}

public function exportPdf()
{
    $hasil = PerolehanNilai::with([
        'siswa',
        'kuis'
    ])
    ->latest()
    ->get();

    $pdf = Pdf::loadView(
        'exports.hasil-pdf',
        compact('hasil')
    );

    return $pdf->download(
        'hasil_penilaian.pdf'
    );
}
    // =========================
    // GET HASIL NILAI
    // =========================
    public function index()
    {
        $hasil = PerolehanNilai::with([
            'siswa',
            'kuis'
        ])
        ->latest()
        ->get();

        $formatted = [];

        foreach ($hasil as $item) {

            $formatted[] = [

                'id' =>
                    $item->id_perolehan_nilai,

                'siswa' =>
                    $item->siswa->nama ?? '-',

                'kuis' =>
                    $item->kuis->judul ?? '-',

                'nilai' =>
                    $item->total_nilai,

                'tanggal' =>
                    $item->created_at
                        ->format('Y-m-d'),

                'status' =>
                    $item->total_nilai >= 75
                        ? 'lulus'
                        : 'remedial',


            ];
        }

        return response()->json($formatted);
    }
}
