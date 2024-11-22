@extends('template.index')

@section('content')

    <section id="monev">
        <div class="section-title text-center">
<<<<<<< HEAD
            <p class="fs-1 fw-bold">Template <span> {{ $title }}</span></p>
=======
            <p class="fs-1 fw-bold">Form <span> {{ $title }}</span></p>
>>>>>>> 250ab6d41aa9fde7ed758faa268346ec9e2b0f5b
        </div>
        <div class="container">
            <div class="row justify-content-center">
                @foreach ($template as $t)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="{{ asset('img/checklist.png') }}" class="card-img-top mt-2" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center fw-bold">{{ $t->nama }}</h5>
                                <a href="/detail/template/{{ $t->slug }}" class="btn btn-primary">Lihat Form</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
