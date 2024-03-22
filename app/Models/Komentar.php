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
        return $this->belongsTo(Pelajaran::class, 'id_pelajaran');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengirim');
    }
}
