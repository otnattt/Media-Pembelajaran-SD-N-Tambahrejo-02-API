<?php
namespace App\Models;
use App\Models\Kuis;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'tb_guru';

    protected $primaryKey = 'id_guru';

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password'
    ];
    // Relasi satu guru memiliki banyak kuis
public function kuis()
{
    return $this->hasMany(Kuis::class, 'id_guru', 'id_guru');
}
}
