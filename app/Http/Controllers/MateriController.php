<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\DetailMateri;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMateriRequest;
use App\Http\Requests\UpdateMateriRequest;

class MateriController extends Controller
{
    public function uploadMateri(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'file' => 'required|mimes:pdf,doc,docx,txt,mp4,jpg,jpeg,png,xls,xlsx',
            // 'video' => 'nullable|mimetypes:video/mp4',
        ]);

        $materi = Materi::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'id_pelajaran' => $request->id_pelajaran,
        ]);

        foreach ($request->file('files') as $file) {
            $namaFile = $file->getClientOriginalName();
            $pathFile = $file->store('files');

            $ekstensi = $file->getClientOriginalExtension();
            $ekstensiDokumen = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt'];
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

            DetailMateri::create([
                'id_materi' => $materi->id,
                'nama_file' => $namaFile,
                'path_file' => $pathFile,
                'tipe_file' => $tipeFile,
            ]);
        }

        // if ($request->hasFile('video')) {
        //     foreach ($request->file('videos') as $video) {
        //         $namaVideo = $video->getClientOriginalName();
        //         $pathVideo = $video->store('videos');


        //         DetailMateri::create([
        //             'id_materi' => $materi->id,
        //             'nama_video' => $namaVideo,
        //             'path_video' => $pathVideo,
        //         ]);
        //     }
        // }

        return redirect()->back()->with('success', 'Materi berhasil diunggah.');
    }
}
