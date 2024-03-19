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
            'file' => 'required|mimes:pdf,doc,docx,txt',
            'video' => 'nullable|mimetypes:video/mp4',
        ]);

        $materi = Materi::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'id_pelajaran' => $request->id_pelajaran,
        ]);

        foreach ($request->file('files') as $file) {
            $namaFile = $file->getClientOriginalName();
            $pathFile = $file->store('files');

            DetailMateri::create([
                'id_materi' => $materi->id,
                'nama_file' => $namaFile,
                'path_file' => $pathFile,
            ]);
        }

        if ($request->hasFile('video')) {
            foreach ($request->file('videos') as $video) {
                $namaVideo = $video->getClientOriginalName();
                $pathVideo = $video->store('videos');


                DetailMateri::create([
                    'id_materi' => $materi->id,
                    'nama_video' => $namaVideo,
                    'path_video' => $pathVideo,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Materi berhasil diunggah.');
    }
}
