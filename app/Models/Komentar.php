<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function pelajaran()
    {
        $this->belongsTo(Pelajaran::class, 'id_pelajaran');
    }

    public function user()
    {
        $this->belongsTo(User::class, 'id_pengirim');
    }
}
