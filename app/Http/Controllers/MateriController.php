<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Pelajaran;
use App\Models\DetailMateri;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMateriRequest;
use App\Http\Requests\UpdateMateriRequest;
use Yaza\LaravelGoogleDriveStorage\Gdrive;

class MateriController extends Controller
{
    // public function uploadMateri(Request $request)
    // {
    //     $request->validate([
    //         'judul' => 'required|string',
    //         'deskripsi' => 'required|string',
    //         'files' => 'required',
    //         'files.*' => 'mimes:pdf,doc,docx,txt,mp4,jpg,jpeg,png,xls,xlsx',
    //     ]);

    //     $materi = Materi::create([
    //         'judul' => $request->judul,
    //         'deskripsi' => $request->deskripsi,
    //         'id_pelajaran' => $request->id_pelajaran,
    //     ]);

    //     foreach ($request->file('files') as $file) {
    //         $folderPath = 'your-folder/';
    //         $fileName = $file->getClientOriginalName();
    //         $filePath = $folderPath . $fileName;

    //         $pathFile = Gdrive::put($filePath, file_get_contents($file->getRealPath()));

    //         $ekstensi = $file->getClientOriginalExtension();
    //         $tipeFile = $this->getFileType($ekstensi);

    //         DetailMateri::create([
    //             'id_materi' => $materi->id,
    //             'nama_file' => $fileName,
    //             'path_file' => $pathFile,
    //             'tipe_file' => $tipeFile,
    //         ]);
    //     }

    //     return redirect()->back()->with('success', 'Materi berhasil diunggah ke Google Drive.');
    // }

    // public function editMateri(Request $request, $pelajaran, $idMateri)
    // {
    //     $request->validate([
    //         'judul' => 'required|string',
    //         'deskripsi' => 'required|string',
    //     ]);

    //     $materi = Materi::findOrFail($idMateri);

    //     $materi->judul = $request->judul;
    //     $materi->deskripsi = $request->deskripsi;
    //     $materi->id_pelajaran = $pelajaran;
    //     $materi->save();

    //     if ($request->hasFile('files')) {
    //         foreach ($request->file('files') as $file) {
    //             $folderPath = 'materi/';
    //             $fileName = $file->getClientOriginalName();
    //             $filePath = $folderPath . $fileName;

    //             $pathFile = Gdrive::put($filePath, file_get_contents($file->getRealPath()));

    //             $ekstensi = $file->getClientOriginalExtension();
    //             $tipeFile = $this->getFileType($ekstensi);

    //             DetailMateri::create([
    //                 'id_materi' => $materi->id,
    //                 'nama_file' => $fileName,
    //                 'path_file' => $pathFile,
    //                 'tipe_file' => $tipeFile,
    //             ]);
    //         }
    //     }

    //     return redirect()->back()->with('success', 'Materi berhasil diperbarui.');
    // }



    public function guruIndex($pelajaran)
    {
        $title = 'Materi';
        $materis = Materi::where('id_pelajaran', $pelajaran)->get();
        $pelajaran = Pelajaran::findOrFail($pelajaran);
        return view('guru.materi.index', compact('title', 'materis', 'pelajaran'));
    }

    public function siswaIndex($pelajaran)
    {
        $title = 'Materi';
        $materis = Materi::where('id_pelajaran', $pelajaran)->get();
        $pelajaran = Pelajaran::findOrFail($pelajaran);
        return view('siswa.materi.index', compact('title', 'materis', 'pelajaran'));
    }

    public function siswaShow($idPelajaran, $idMateri)
    {
        $title = 'Detail Materi';
        $materi = Materi::where('id', $idMateri)->first();
        $pelajaran = Pelajaran::findOrFail($idPelajaran);

        $materis = Materi::where('id_pelajaran', $idPelajaran)->get();
        $details = DetailMateri::where('id_materi', $idMateri)->get();
        $videos = DetailMateri::where('id_materi', $idMateri)->where('tipe_file', 'video')->get();
        $dokumens = DetailMateri::where('id_materi', $idMateri)->where('tipe_file', 'dokumen')->get();
        $gambars = DetailMateri::where('id_materi', $idMateri)->where('tipe_file', 'gambar')->get();

        return view('siswa.materi.detail', compact('title', 'materi', 'materis', 'pelajaran', 'details', 'videos', 'dokumens', 'gambars'));
    }


    public function show($idPelajaran, $idMateri)
    {
        $materi = Materi::where('id', $idMateri)->first();
        $pelajaran = Pelajaran::findOrFail($idPelajaran);
        $details = DetailMateri::where('id_materi', $idMateri)->get();
        $title = 'Detail Materi';

        if (auth()->user()->role === 'guru') {
            return view('guru.materi.detail', compact('title', 'materi', 'pelajaran', 'details'));
        } else {
            $materis = Materi::where('id_pelajaran', $idPelajaran)->get();
            return view('siswa.materi.detail', compact('title', 'materi', 'materis', 'pelajaran', 'details'));
        }
    }

    public function uploadMateri(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
        ]);

        $materi = Materi::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'id_pelajaran' => $request->id_pelajaran,
        ]);

        foreach ($request->file('files') as $file) {
            $namaFile = $file->getClientOriginalName();
            $pathFile = $file->store('materi');
            $ekstensi = $file->getClientOriginalExtension();
            $tipeFile = $this->getFileType($ekstensi);


            DetailMateri::create([
                'id_materi' => $materi->id,
                'nama_file' => $namaFile,
                'path_file' => $pathFile,
                'tipe_file' => $tipeFile,
            ]);
        }

        return redirect()->back()->with('success', 'Materi berhasil diunggah.');
    }

    private function getFileType($extension)
    {
        $ekstensiDokumen = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'pptx'];
        $ekstensiGambar = ['jpg', 'jpeg', 'png'];
        $ekstensiVideo = ['mp4'];

        if (in_array($extension, $ekstensiDokumen)) {
            return 'dokumen';
        } elseif (in_array($extension, $ekstensiGambar)) {
            return 'gambar';
        } elseif (in_array($extension, $ekstensiVideo)) {
            return 'video';
        } else {
            return 'lainnya';
        }
    }

    public function editMateri(Request $request, $pelajaran, $idMateri)
    {
        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
        ]);

        $materi = Materi::findOrFail($idMateri);

        $materi->judul = $request->judul;
        $materi->deskripsi = $request->deskripsi;
        $materi->id_pelajaran = $pelajaran;
        $materi->save();

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $namaFile = $file->getClientOriginalName();
                $file->storeAs('public/materi', $namaFile);
                $pathFile = 'storage/materi/' . $namaFile;

                $ekstensi = $file->getClientOriginalExtension();
                $tipeFile = $this->getFileType($ekstensi);

                $detailMateri = DetailMateri::updateOrCreate(
                    ['id_materi' => $materi->id, 'nama_file' => $namaFile],
                    ['path_file' => $pathFile, 'tipe_file' => $tipeFile]
                );
            }
        }

        return redirect()->back()->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy($pelajaran, $idMateri)
    {
        $materi = Materi::find($idMateri);
        $details = DetailMateri::where('id_materi', $idMateri)->get();

        foreach ($details as $detail) {
            $detail->delete();
        }

        $materi->delete();

        return redirect()->back()->with('success', 'Materi berhasil dihapus.');
    }

    public function deleteFile($pelajaran, $idMateri, $idFile)
    {
        $file = DetailMateri::find($idFile);
        $file->delete();

        return redirect()->back()->with('success', 'File berhasil dihapus.');
    }
}
