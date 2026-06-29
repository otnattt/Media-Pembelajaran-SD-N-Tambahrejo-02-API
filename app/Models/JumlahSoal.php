<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JumlahSoal extends Model
{
    protected $table = 'tb_jumlah_soal';

    protected $primaryKey = 'id_jumlah_soal';

    protected $fillable = [
        'jml_soal'
    ];
}
