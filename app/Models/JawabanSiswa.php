<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanSiswa extends Model
{
    protected $table = 'tb_jawaban_siswa';

    protected $primaryKey = 'id_jawaban_siswa';

    protected $fillable = [
        'id_detail_kuis',
        'id_siswa',
        'jawaban_siswa',
        'perolehan_point',
    ];
    // RELASI DETAIL KUIS
public function detailKuis()
{
    return $this->belongsTo(
        DetailKuis::class,
        'id_detail_kuis',
        'id_detail_kuis'
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
}

