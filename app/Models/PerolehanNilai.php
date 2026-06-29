<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerolehanNilai extends Model
{
    protected $table = 'tb_perolehan_nilai';

    protected $primaryKey = 'id_perolehan_nilai';

    protected $fillable = [
        'id_siswa',
        'id_kuis',
        'id_jawaban_siswa',
        'total_nilai',
    ];

    // RELASI JAWABAN SISWA
    public function jawabanSiswa()
    {
        return $this->belongsTo(
            JawabanSiswa::class,
            'id_jawaban_siswa',
            'id_jawaban_siswa'
        );
    }

    // RELASI SISWA
    public function siswa()
    {
        return $this->belongsTo(
            Siswa::class,
            'id_siswa',
            'id_siswa'
        );
    }

    // RELASI KUIS
    public function kuis()
    {
        return $this->belongsTo(
            Kuis::class,
            'id_kuis',
            'id_kuis'
        );
    }
}
