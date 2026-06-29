<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuis extends Model
{
    protected $table = 'tb_kuis';

    protected $primaryKey = 'id_kuis';

    protected $fillable = [
        'id_guru',
        'judul',
        'deskripsi',
        'status',
        'tanggal_dibuat',
        'total_soal',
    ];

    protected $casts = [
        'tanggal_dibuat' => 'datetime',
    ];

    // RELASI GURU
    public function guru()
    {
        return $this->belongsTo(
            Guru::class,
            'id_guru',
            'id_guru'
        );
    }

    // RELASI DETAIL KUIS
    public function detailKuis()
    {
        return $this->hasMany(
            DetailKuis::class,
            'id_kuis',
            'id_kuis'
        );
    }

    public function jumlahSoal()
{
    return $this->hasOne(
        JumlahSoal::class,
        'id_kuis',
        'id_kuis'
    );
}
}

