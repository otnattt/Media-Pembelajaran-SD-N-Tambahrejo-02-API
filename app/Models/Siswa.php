<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'tb_siswa';

    protected $primaryKey = 'id_siswa';

    protected $fillable = [
        'nama',
        'nis',
        'status_siswa'
    ];
}
