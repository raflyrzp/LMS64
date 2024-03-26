<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Pelajaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
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
            $foto = $request->file('foto');
            $foto->storeAs('public/bg_pelajaran', $foto->hashName());

            Pelajaran::create([
                'mata_pelajaran' => $request->mata_pelajaran,
                'id_kelas' => $request->id_kelas,
                'id_guru' => $request->id_guru,
                'deskripsi' => $request->deskripsi,
                'foto' => $foto->hashName()
            ]);
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
        ])->whereNotIn('id', [$id])->exists();

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
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $foto->storeAs('public/bg_pelajaran', $foto->hashName());

                if ($pelajaran->foto !== 'default.jpg') {
                    Storage::delete('public/bg_pelajaran/' . $pelajaran->foto);
                }

                $pelajaran->update([
                    'mata_pelajaran' => $request->mata_pelajaran,
                    'id_kelas' => $request->id_kelas,
                    'id_guru' => $request->id_guru,
                    'deskripsi' => $request->deskripsi,
                    'foto' => $foto->hashName()
                ]);
                return redirect()->back()->with('success', 'Pelajaran berhasil diubah.');
            } else {
                $pelajaran->update([
                    'mata_pelajaran' => $request->mata_pelajaran,
                    'id_kelas' => $request->id_kelas,
                    'id_guru' => $request->id_guru,
                    'deskripsi' => $request->deskripsi,
                ]);
                return redirect()->back()->with('success', 'Pelajaran berhasil diubah.');
            }
        }
    }


    public function destroy($id)
    {
        $pelajaran = Pelajaran::findOrFail($id);

        $materis = Materi::where('id_pelajaran', $id)->get();

        foreach ($materis as $materi) {
            $materi->delete();
        }
        Storage::delete('public/bg_pelajaran/' . $pelajaran->foto);
        $pelajaran->delete();

        return redirect()->back()->with('success', 'Pelajaran berhasil dihapus.');
    }
}
