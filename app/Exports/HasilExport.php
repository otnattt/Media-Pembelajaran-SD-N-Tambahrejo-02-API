<?php

namespace App\Exports;

use App\Models\PerolehanNilai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HasilExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return PerolehanNilai::with([
            'siswa',
            'kuis'
        ])
        ->latest()
        ->get()
        ->map(function ($item) {

            return [

                'siswa' =>
                    $item->siswa->nama ?? '-',

                'kuis' =>
                    $item->kuis->judul ?? '-',

                'nilai' =>
                    $item->total_nilai,

                'tanggal' =>
                    $item->created_at->format('Y-m-d'),

                'status' =>
                    $item->total_nilai >= 75
                        ? 'Lulus'
                        : 'Remedial',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Siswa',
            'Kuis',
            'Nilai',
            'Tanggal',
            'Status'
        ];
    }
}
