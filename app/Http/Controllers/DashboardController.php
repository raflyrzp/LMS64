<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Pelajaran;
use App\Models\DetailPengumpulan;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDetailPengumpulanRequest;
use App\Http\Requests\UpdateDetailPengumpulanRequest;

class DashboardController extends Controller
{
    public function siswaIndex()
    {
        $title = 'Dashboard';
        $kelas = Kelas::findOrFail(auth()->user()->id_kelas);
        $pelajarans = Pelajaran::where('id_kelas', auth()->user()->id_kelas)->get();
        return view('siswa.index', compact('kelas', 'pelajarans', 'title'));
    }

    public function guruIndex()
    {
        $title = 'Dashboard';
        $kelass = Kelas::all();
        $pelajarans = Pelajaran::where('id_guru', auth()->id())->get();
        return view('guru.index', compact('pelajarans', 'title', 'kelass'));
    }
}
