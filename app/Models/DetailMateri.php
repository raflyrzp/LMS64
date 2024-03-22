<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailMateri extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'id_materi');
    }
}
