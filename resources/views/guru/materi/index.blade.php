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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">List Materi</h3>
                                <a href="" class="btn btn-primary float-right" data-toggle="modal"
                                    data-target="#tambahModal"><i class="fas fa-plus"></i>
                                    Tambah</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul Materi</th>
                                            <th>Deskripsi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($materis as $i => $materi)
                                            <a href="">
                                                <tr>
                                                    <td class="col-1">{{ $i + 1 }}</td>
                                                    <td>{{ $materi->judul }}</td>
                                                    <td>{{ $materi->deskripsi }}</td>
                                                    <td style="width: 6em;">
                                                        <a href="{{ route('materi.show', [$pelajaran->id, $materi->id]) }}"
                                                            class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                                        <form
                                                            action="{{ route('materi.destroy', [$pelajaran->id, $materi->id]) }}"
                                                            method="post" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Anda yakin ingin menghapus materi ini?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>

                                                </tr>
                                            </a>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
@endsection
