<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Pelajaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePelajaranRequest;
use App\Http\Requests\UpdatePelajaranRequest;

class PelajaranController extends Controller
{
    public function index($pelajaran, $id)
    {
        $title = 'Materi';
        $materis = Materi::where('id_pelajaran', $id)->get();
        return view('siswa.pelajaran', compact('title', 'materis'));
    }

    public function store(Request $request)
    {
        $existingData = Pelajaran::where([
            ['mata_pelajaran', $request->mata_pelajaran],
            ['id_kelas', $request->id_kelas],
            ['id_guru', $request->id_guru],
        ])->exists();

        if ($existingData) {
            return redirect()->back()->with('error', 'Mata pelajaran sudah ada.');
        } else {
            $request->validate([
                'mata_pelajaran' => 'required|string',
                'id_kelas' => 'required|exists:kelas,id',
                'id_guru' => 'required|exists:users,id',
                'deskripsi' => 'required|string',
            ]);

            Pelajaran::create($request->all());

            return redirect()->back()->with('success', 'Pelajaran berhasil dibuat.');
        }
    }


    public function show(Pelajaran $pelajaran)
    {
        //
    }


    public function edit(Pelajaran $pelajaran)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $existingData = Pelajaran::where([
            ['mata_pelajaran', $request->mata_pelajaran],
            ['id_kelas', $request->id_kelas],
            ['id_guru', $request->id_guru],
        ])->exists();

        if ($existingData) {
            return redirect()->back()->with('error', 'Mata pelajaran sudah ada.');
        } else {
            $request->validate([
                'mata_pelajaran' => 'required|string',
                'id_kelas' => 'required|exists:kelas,id',
                'id_guru' => 'required|exists:users,id',
                'deskripsi' => 'required|string',
            ]);

            $pelajaran = Pelajaran::findOrFail($id);

            $pelajaran->update($request->all());

            return redirect()->back()->with('success', 'Pelajaran berhasil dibuat.');
        }
    }


    public function destroy($id)
    {
        $pelajaran = Pelajaran::findOrFail($id);
        $pelajaran->delete();

        return redirect()->back()->with('success', 'Pelajaran berhasil dihapus.');
    }
}
