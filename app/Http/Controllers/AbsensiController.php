<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAbsensiRequest;
use App\Http\Requests\UpdateAbsensiRequest;

class AbsensiController extends Controller
{
    public function absen(Request $request)
    {
        $absensiHariIni = Absensi::where('id_siswa', $request->id_siswa)
            ->whereDate('created_at', now()->toDateString())
            ->first();

        if ($absensiHariIni) {
            return "Absensi sudah ditandai untuk hari ini.";
        }

        Absensi::create([
            'id_kelas' => $request->id_kelas,
            'id_siswa' => $request->id_siswa,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Absensi telah dicatat.');
    }
}
