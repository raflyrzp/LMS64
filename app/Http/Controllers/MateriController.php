<?php

namespace App\Http\Controllers;

use App\Models\Materi;
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

    public function uploadMateri(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            // 'file' => 'required|mimes:pdf,doc,docx,txt,mp4,jpg,jpeg,png,xls,xlsx',
            // 'video' => 'nullable|mimetypes:video/mp4',
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

    public function editMateri(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            // 'file' => 'nullable|mimes:pdf,doc,docx,txt,mp4,jpg,jpeg,png,xls,xlsx',
            // 'video' => 'nullable|mimetypes:video/mp4',
        ]);

        $materi = Materi::findOrFail($id);

        $materi->judul = $request->judul;
        $materi->deskripsi = $request->deskripsi;
        $materi->id_pelajaran = $request->id_pelajaran;
        $materi->save();

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $namaFile = $file->getClientOriginalName();
                $pathFile = $file->store('files');

                $ekstensi = $file->getClientOriginalExtension();
                $ekstensiDokumen = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'pptx'];
                $ekstensiGambar = ['jpg', 'jpeg', 'png'];
                $ekstensiVideo = ['mp4'];

                if (in_array($ekstensi, $ekstensiDokumen)) {
                    $tipeFile = 'dokumen';
                } elseif (in_array($ekstensi, $ekstensiGambar)) {
                    $tipeFile = 'gambar';
                } elseif (in_array($ekstensi, $ekstensiVideo)) {
                    $tipeFile = 'video';
                } else {
                    return redirect()->back()->with('error', 'Tipe file tidak didukung');
                }

                $detailMateri = DetailMateri::updateOrCreate(
                    ['id_materi' => $materi->id, 'nama_file' => $namaFile],
                    ['path_file' => $pathFile, 'tipe_file' => $tipeFile]
                );
            }
        }

        return redirect()->back()->with('success', 'Materi berhasil diperbarui.');
    }
}
