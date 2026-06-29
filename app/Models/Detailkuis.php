<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailKuis extends Model
{
    protected $table = 'tb_detail_kuis';

    protected $primaryKey = 'id_detail_kuis';

    protected $fillable = [
        'id_kuis',
        'pertanyaan',
        'pilihan_a',
        'pilihan_b',
        'pilihan_c',
        'pilihan_d',
        'jawaban',
        'poin',
    ];

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
