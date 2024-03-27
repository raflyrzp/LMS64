@extends('layout.main_admin')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Materi</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Materi</li>
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <h3 class="card-title">
                                    {{ $materi->judul }}
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ route('materi.edit', [$pelajaran->id, $materi->id]) }}" method="POST"
                                    enctype="multipart/form-data" id="fileUploadForm">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="judul">Judul</label>
                                        <input type="text" class="form-control" id="judul" name="judul"
                                            value="{{ $materi->judul }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="deskripsi">Deskripsi</label>
                                        <textarea id="summernote" name="deskripsi">{{ $materi->deskripsi }}</textarea>
                                    </div>



                                    <div id="fileInputsContainer">
                                        <div class="form-group">
                                            <label for="file">File</label>

                                            <div id="file" class="row mb-2">
                                                <table class="table table-bordered table-hover col-12">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama File</th>
                                                            <th>Tipe File</th>
                                                            <th class="text-center">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($details as $i => $detail)
                                                            <a href="">
                                                                <tr>
                                                                    <td class="col-1">{{ $i + 1 }}</td>
                                                                    <td>{{ $detail->nama_file }}</td>
                                                                    <td>{{ $detail->tipe_file }}</td>
                                                                    <td style="width: 6em;" class="text-center">
                                                                        <button type="button" class="btn btn-sm btn-danger"
                                                                            data-toggle="modal"
                                                                            data-target="#deleteModal{{ $detail->id }}"><i
                                                                                class="fas fa-trash"></i></button>
                                                                    </td>

                                                                </tr>
                                                            </a>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <input type="file" name="files[]" class="form-control" multiple>
                                        </div>
                                    </div>


                                    <button type="button" class="btn btn-success" id="addFileInput">Tambahkan File</button>

                                    <button type="submit" class="btn btn-primary float-right">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                </div>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->

    @foreach ($details as $detail)
        {{-- DELETE --}}
        <div class="modal fade" id="deleteModal{{ $detail->id }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel{{ $detail->id }}" aria-hidden="true">
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
                            Apakah anda yakin ingin menghapus File ini?
                        </p>
                        <p>
                            Nama File : {{ $detail->nama_file }}
                        </p>
                        <p>
                            Tipe File : {{ $detail->tipe_file }}
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Batal</span>
                        </button>

                        <form action="{{ route('file.delete', [$pelajaran->id, $materi->id, $detail->id]) }}"
                            method="post" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Anda yakin ingin menghapus materi ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('addFileInput').addEventListener('click', function() {
                var fileInput = document.createElement('div');
                fileInput.className = 'form-group';
                fileInput.innerHTML = `
                <div class="row ml-1">
                    <input type="file" name="files[]" class="form-control mt-2 col-11" multiple>
                    <button type="button" class="btn btn-danger mt-2 removeFileInput ml-3"><i class="fas fa-trash"></i></button></div>
                `;

                document.getElementById('fileInputsContainer').appendChild(fileInput);
            });

            document.getElementById('fileInputsContainer').addEventListener('click', function(event) {
                if (event.target.classList.contains('removeFileInput')) {
                    event.target.parentElement.remove();
                }
            });
        });
    </script>
@endsection
