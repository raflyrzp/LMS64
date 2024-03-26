@extends('layout.main')

@section('content')
    <div class="row">
        <div class="col-sm-6 mb-4 mb-xl-0">
            <div class="d-lg-flex align-items-center">
                <div>
                    <button type="button" class="btn btn-sm btn-primary mb-1" data-bs-toggle="modal"
                        data-bs-target="#tambahModal"><i class="ti-plus"></i> Tambah</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-12 grid-margin">

            <ul class="cards">
                @forelse ($pelajarans as $pelajaran)
                    <li>
                        <a href="{{ route('siswa.pelajaran', [$pelajaran->mata_pelajaran, $pelajaran->id]) }}"
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
                                        <span
                                            class="card__status">{{ $pelajaran->kelas->nama_kelas . ' (' . $pelajaran->kelas->angkatan . ')' }}</span>
                                    </div>
                                </div>
                                <p class="card__description">{{ $pelajaran->deskripsi }}
                                </p>
                            </div>
                        </a>
                        <button type="button" class="btn btn-sm btn-primary mt-2" data-bs-toggle="modal"
                            data-bs-target="#editModal{{ $pelajaran->id }}"><i class="mdi mdi-grease-pencil"></i></button>

                        <button type="button" class="btn btn-sm btn-danger mt-2" data-bs-toggle="modal"
                            data-bs-target="#deleteModal{{ $pelajaran->id }}"><i
                                class="mdi mdi-delete-forever"></i></button>
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

    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="tambahModalLabel">Tambah Produk</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('pelajaran.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_guru" value="{{ auth()->id() }}">
                        <div class="form-group">
                            <label for="mata_pelajaran">Mata Pelajran</label>
                            <input id="mata_pelajaran" name="mata_pelajaran" type="text" placeholder=""
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="Kelas">Kelas (Angkatan)</label>
                            <select class="form-control" name="id_kelas">
                                @foreach ($kelass as $kelas)
                                    <option value="{{ $kelas->id }}">
                                        {{ $kelas->nama_kelas . ' (' . $kelas->angkatan . ')' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="10" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="foto">Background</label>
                            <input type="file" class="form-control" name="foto">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Tutup</span>
                        </button>
                        <button type="submit" class="btn btn-primary ms-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($pelajarans as $pelajaran)
        <div class="modal fade" id="editModal{{ $pelajaran->id }}" tabindex="-1" role="dialog"
            aria-labelledby="tambahModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="tambahModalLabel">Edit Pelajaran</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('pelajaran.update', $pelajaran->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" name="id_guru" value="{{ auth()->id() }}">
                            <div class="form-group">
                                <label for="mata_pelajaran">Mata Pelajaran</label>
                                <input id="mata_pelajaran" name="mata_pelajaran" type="text" placeholder=""
                                    class="form-control" required value="{{ $pelajaran->mata_pelajaran }}">
                            </div>
                            <div class="form-group">
                                <label for="Kelas">Kelas (Angkatan)</label>
                                <select class="form-control" name="id_kelas">
                                    @foreach ($kelass as $kelas)
                                        <option value="{{ $kelas->id }}"
                                            @if ($kelas->id === $pelajaran->id_kelas) selected @endif>
                                            {{ $kelas->nama_kelas . ' (' . $kelas->angkatan . ')' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="10" required>{{ $pelajaran->deskripsi }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="foto">Background</label><br>
                                <img src="{{ asset('./storage/bg_pelajaran/' . $pelajaran->foto) }}" width="100px"
                                    class="mb-2">
                                <input type="file" class="form-control" name="foto">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Tutup</span>
                            </button>
                            <button type="submit" class="btn btn-primary ms-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Simpan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        {{-- DELETE --}}
        <div class="modal fade" id="deleteModal{{ $pelajaran->id }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel{{ $pelajaran->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Hapus Produk
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Apakah anda yakin ingin menghapus pelajaran ini?
                        </p>
                        <p>
                            Mata Pelajaran : {{ $pelajaran->mata_pelajaran }}
                        </p>
                        <p>
                            Kelas : {{ $pelajaran->kelas->nama_kelas }}
                        </p>
                        <p>
                            Guru : {{ $pelajaran->user->fullname }}
                        </p>
                        <p>
                            Deskripsi : {{ $pelajaran->deskripsi }}
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Batal</span>
                        </button>

                        <form action="{{ route('pelajaran.destroy', $pelajaran->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger ms-1">
                                Hapus
                            </button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
