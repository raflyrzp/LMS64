<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPengumpulan extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function pengumpulan()
    {
        return $this->belongsTo(Pengumpulan::class, 'id_pengumpulan');
    }
}
