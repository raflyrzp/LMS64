<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelajaran extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function kelas()
    {
        $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function user()
    {
        $this->belongsTo(User::class, 'id_guru');
    }
}
