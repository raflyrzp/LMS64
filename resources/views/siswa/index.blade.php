@extends('layout.main')

@section('content')
    <div class="row">
        <div class="col-sm-6 mb-4 mb-xl-0">
            <div class="d-lg-flex align-items-center">
                <div>
                    <h3 class="text-dark font-weight-bold mb-2">{{ $kelas->nama_kelas . ' (' . $kelas->angkatan . ')' }}</h3>
                    <h6 class="font-weight-normal mb-2">{{ $kelas->deskripsi }}</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-12 grid-margin">

            <ul class="cards">
                @forelse ($pelajarans as $pelajaran)
                    @php
                        $materi = App\Models\Materi::where('id_pelajaran', $pelajaran->id)->first();
                    @endphp
                    <li>
                        <a href="{{ $materi ? route('siswa.materi.show', [$pelajaran->id, $materi->id]) : route('siswa.materi', $pelajaran->id) }}"
                            class="pelajaran-card">
                            <img src="{{ asset('./storage/bg_pelajaran/' . $pelajaran->foto) }}" class="card__image"
                                alt="" />
                            <div class="card__overlay">
                                <div class="card__header">
                                    <svg class="card__arc" xmlns="http://www.w3.org/2000/svg">
                                        <path />
                                    </svg>
                                    <img class="card__thumb" src="{{ asset('assets/images/faces/adel.jpg') }}"
                                        alt="" />
                                    <div class="card__header-text">
                                        <h3 class="card__title">{{ $pelajaran->mata_pelajaran }}</h3>
                                        <span class="card__status">{{ $pelajaran->user->fullname }}</span>
                                    </div>
                                </div>
                                <p class="card__description">{{ $pelajaran->deskripsi }}</p>
                            </div>
                        </a>
                    </li>
                @empty
                    <div class="card col-lg-6 col-sm-12">
                        <div class="wrapper">
                            <div class="label">Anda belum memasuki kelas, masukkan kode kelas anda pada form di bawah!
                            </div>
                            <div class="searchBar">
                                <form action="{{ route('join.kelas') }}" method="post">
                                    @csrf
                                    <input id="searchQueryInput" type="text" name="kode_kelas" placeholder="Kode kelas"
                                        value="" />
                                    <button id="searchQuerySubmit" type="submit" name="submit">
                                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                            <path fill="#666666"
                                                d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
