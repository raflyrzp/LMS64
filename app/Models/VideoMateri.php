<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoMateri extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function materi()
    {
        $this->belongsTo(Materi::class, 'id_materi');
    }
}
