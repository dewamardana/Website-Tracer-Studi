@extends('template.index')

@section('content')

    <section id="monev">
        <div class="section-title text-center">
            <p class="fs-1 fw-bold">Data <span> {{ $title }}</span></p>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                @foreach ($form as $f)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="{{ asset('img/checklist.png') }}" class="card-img-top mt-2" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center fw-bold">{{ $f->nama }}</h5>
                                <a href="/detail/answer/{{ $f->id }}" class="btn btn-primary">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
