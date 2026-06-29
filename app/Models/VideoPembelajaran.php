<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoPembelajaran extends Model
{
    protected $table = 'tb_videoPembelajaran';

    protected $primaryKey = 'id_vidpem';

  protected $fillable = [
    'id_guru',
    'judul',
    'deskripsi',
    'file_video',
    'durasi_video',
    'status_video',
];
}
