<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreKelasRequest;
use App\Http\Requests\UpdateKelasRequest;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        return view('siswa.index', compact('kelas'));
    }

    public function joinKelas(Request $request)
    {
        $request->validate([
            'kode_kelas' => 'required|string',
        ]);

        $kelas = Kelas::where('kode_kelas', $request->kode_kelas)->first();

        if ($kelas) {
            $user = User::findOrFail(auth()->id());
            $user->id_kelas = $kelas->id;
            $user->save();

            return redirect()->back()->with('success', 'Berhasil bergabung ke kelas.');
        } else {
            return redirect()->back()->with('error', 'Kode kelas tidak valid.');
        }
    }

    public function keluarKelas($id)
    {
        $user = User::findOrFail($id);

        $user->id_kelas = null;
        $user->save();

        if (auth()->user()->role === 'siswa') {
            return redirect()->route('kelas.user')->with('success', 'Anda telah keluar dari kelas.');
        } else {
            return redirect()->route('kelas.user')->with('success', 'Berhasil mengeluarkan seorang siswa dari kelas.');
        }
    }

    public function buatKelas(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string',
            'deskripsi' => 'required|string',
            'angkatan' => 'required'
        ]);

        $namaKelasTanpaSpasi = str_replace(' ', '', $request->nama_kelas);
        $kodeKelas = $namaKelasTanpaSpasi . $request->angkatan . Str::random(5);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'angkatan' => $request->angkatan,
            'kode_kelas' => $kodeKelas,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function editKelas(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string',
            'deskripsi' => 'required|string',
            'angkatan' => 'required',
        ]);

        $kelas = Kelas::findOrFail($id);

        $kodeKelas = $request->nama_kelas . '_' . $request->angkatan;

        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
            'angkatan' => $request->angkatan,
            'kode_kelas' => $kodeKelas,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function hapusKelas($id)
    {
        $kelas = Kelas::findOrFail($id);

        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
