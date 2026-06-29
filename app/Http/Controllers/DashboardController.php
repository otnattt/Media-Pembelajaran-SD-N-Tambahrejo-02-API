<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function statistik()
    {
        $totalVideo = DB::table('tb_videoPembelajaran')->count();

        $videoAktif = DB::table('tb_videoPembelajaran')
            ->where('status_video', 'aktif')
            ->count();

        $totalKuis = DB::table('tb_kuis')->count();

        $totalSiswa = DB::table('tb_siswa')->count();

        $totalHasil = DB::table('tb_perolehan_nilai')->count();

        return response()->json([
            'total_video' => $totalVideo,
            'video_aktif' => $videoAktif,
            'total_kuis' => $totalKuis,
            'total_siswa' => $totalSiswa,
            'total_hasil' => $totalHasil,
        ]);
    }
}
