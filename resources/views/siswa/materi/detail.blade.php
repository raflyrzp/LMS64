@extends('layout.main')

@section('content')
    <style>
        .styled-number {
            background: #0DDBB9;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            color: #fff;
            font-weight: bold;
            margin: 0;
        }

        .card-active {
            /* color: #fff !important; */
            border-bottom: 5px solid #0DDBB9;
            font-weight: bold;
        }

        .card-list {
            transition: all 0.3s ease-in-out;
            transform-style: preserve-3d;
        }

        .card-list:hover {
            transform: translate(0, -10px) rotateX(5deg);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        .card-list-body {
            transition: all 0.3s ease-in-out;
        }

        .card-list:hover .card-list-body {
            transform: translate(0, 5px);
        }

        .list-materi {
            overflow-y: auto;
            height: 100%;
        }
    </style>
    <div class="row">
        <div class="col-lg-3 grid-margin stretch-card d-flex flex-column gap-3 list-materi">
            @foreach ($materis as $i => $list)
                <a href="{{ route('siswa.materi.show', [$pelajaran->id, $list->id]) }}" style=" text-decoration: none;">
                    <div class="card card-list {{ $materi->id === $list->id ? 'card-active' : '' }}">
                        <div class="card-body card-list-body">
                            <div class="row">
                                <div class="col-lg-2">
                                    <p class="styled-number">{{ $i + 1 }}</p>
                                </div>
                                <div class="col-lg-10">
                                    <h3 class="card-title mb-1 mx-0 mt-0 fs-4">{{ $list->judul }}</h3>
                                    <p class="m-0 text-muted">{{ $list->deskripsi }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="col-lg-9">
            @if (count($videos) > 0)
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h3 class="card-title mb-3 fs-3">Video</h3>
                                <video width="100%" height="500px" id="videoPlayer" controls>
                                    <source src="{{ asset($videos->first()->path_file) }}" type="video/mp4">
                                </video>
                                @foreach ($videos as $video)
                                    <a class="btn btn-dark" href="#"
                                        onclick="changeVideoSource(event, '{{ asset($video->path_file) }}')">{{ $video->nama_file }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="card mt-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3 class="card-title mb-3 fs-3">{{ $materi->judul }}</h3>
                            <p>{{ $materi->deskripsi }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @if (count($dokumens) > 0)
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h3 class="card-title mb-3 fs-5">Lampiran Dokumen</h3>
                                @foreach ($dokumens as $dokumen)
                                    <a class="btn btn-dark" href="{{ asset($dokumen->path_file) }}"
                                        download>{{ $dokumen->nama_file }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (count($gambars) > 0)
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h3 class="card-title mb-3 fs-5">Lampiran Gambar</h3>
                                <div style="display: flex; gap:10px; justify-content:start;">
                                    @foreach ($gambars as $gambar)
                                        <a href="{{ asset($gambar->path_file) }}" target="_blank">
                                            <img src="{{ asset($gambar->path_file) }}" width="250px"></a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif


        </div>
    </div>

    <script>
        function changeVideoSource(event, sourceUrl) {
            event.preventDefault(); // Mencegah link melakukan navigasi

            // Mendapatkan elemen video dan mengubah sumbernya
            var videoPlayer = document.getElementById('videoPlayer');
            videoPlayer.src = sourceUrl;

            // Memuat video baru dan memainkannya
            videoPlayer.load();
            videoPlayer.play();
        }
    </script>
@endsection
