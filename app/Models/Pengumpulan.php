<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumpulan extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function tugas()
    {
        $this->belongsTo(Tugas::class, 'id_tugas');
    }

    public function user()
    {
        $this->belongsTo(User::class, 'id_siswa');
    }
}
