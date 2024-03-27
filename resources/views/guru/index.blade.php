@extends('layout.main_admin')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
                <button type="button" class="btn btn-sm btn-primary mb-1" data-toggle="modal" data-target="#tambahModal"><i
                        class="fas fa-plus"></i> Tambah</button>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-12 col-12" style="display:flex; gap: 10px;">
                        @foreach ($pelajarans as $pelajaran)
                            <div class="card" style="width: 16rem;">
                                <img src="{{ asset('/storage/bg_pelajaran/' . $pelajaran->foto) }}" class="card-img-top"
                                    alt="{{ $pelajaran->mata_pelajaran }}" height="200px" style="object-fit: cover">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $pelajaran->mata_pelajaran }}</h5>
                                    <h6 class="card-subtitle mb-2 mt-1 text-muted">
                                        {{ $pelajaran->kelas->nama_kelas . ' (' . $pelajaran->kelas->angkatan . ')' }}</h6>
                                    <p class="card-text">{{ $pelajaran->deskripsi }}</p>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#editModal{{ $pelajaran->id }}"><i
                                                class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#deleteModal{{ $pelajaran->id }}"><i
                                                class="fas fa-trash"></i></button>
                                        <a href="{{ route('guru.materi', $pelajaran->id) }}" class="btn btn-sm btn-info"><i
                                                class="fas fa-eye"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="tambahModalLabel">Tambah Pelajaran</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                        <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                            <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
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
                        <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
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
