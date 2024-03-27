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

        .card-active,
        .card-active p {
            color: #fff !important;
            background-color: #0DDBB9;
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
            @foreach ($materis as $i => $materi)
                <a href="{{ route('siswa.materi.show', [$pelajaran->id, $materi->id]) }}" style=" text-decoration: none;">
                    <div class="card card-list">
                        <div class="card-body card-list-body">
                            <div class="row">
                                <div class="col-lg-2">
                                    <p class="styled-number">{{ $i + 1 }}</p>
                                </div>
                                <div class="col-lg-10">
                                    <h3 class="card-title mb-1 mx-0 mt-0 fs-4">{{ $materi->judul }}</h3>
                                    <p class="m-0 text-muted">{{ $materi->deskripsi }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3 class="card-title mb-3 fs-3">{{ $materi->judul }}</h3>
                            <p class="mb-0 mt-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus
                                velit ullam numquam exercitationem. Debitis amet laboriosam ullam? Exercitationem obcaecati
                                itaque voluptatibus voluptate enim facilis sed reprehenderit deleniti expedita quam? Quo ex
                                eum laborum labore, voluptatibus commodi magni, sunt, dolore modi veritatis nulla maxime
                                consequatur facere! Expedita quidem sapiente animi! Iste, reiciendis possimus eveniet
                                distinctio incidunt quidem porro iusto aliquid, doloremque inventore esse eos nobis pariatur
                                provident! Neque, facere! Adipisci nemo ut minima magni doloribus? Libero velit, eius
                                perferendis dolores ut eligendi. Illum reiciendis, quod quasi corporis temporibus
                                consectetur, magnam deleniti ullam, distinctio sit praesentium alias animi fugit cumque
                                earum facere!
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
