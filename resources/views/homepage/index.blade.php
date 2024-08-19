@extends('template.index')

@section('content')
    <section id="banner">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="title">Tracer Studi | Kuisioner-Ng</div>
                    <p class="mt-4">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quaerat perspiciatis rerum eveniet nostrum ipsum esse repellat laboriosam temporibus corporis aut!</p>
                </div>
                <div class="col-md-6 text-center">
                    <img src="/img/undraw_website_78wh.svg" alt="" width="500" height="500">
                </div>
            </div>
        </div>
    </section>

    <section id="info">
        <div class="section-title text-center">
            <p class="fs-1 fw-bold">Berita <span>Penting</span></p>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-5">
                    <div class="card">
                        <img src="img/crisis.png" class="card-img-top mt-2" alt="...">
                        <div class="card-body">
                            <h5 class="card-title text-center fw-bold">Pengumuman</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <div class="card">
                        <img src="img/information.png" class="card-img-top mt-2" alt="...">
                        <div class="card-body">
                            <h5 class="card-title text-center fw-bold">Informasi</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <div class="card">
                        <img src="img/crisis.png" class="card-img-top mt-2" alt="...">
                        <div class="card-body">
                            <h5 class="card-title text-center fw-bold">Pengumuman</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="monev">
        <div class="section-title text-center">
            <p class="fs-1 fw-bold">Data <span>Kuisioner</span></p>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                @foreach ($kategori as $k)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="img/checklist.png" class="card-img-top mt-2" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center fw-bold">{{ $k->nama }}</h5>
                                <p class="card-text">{{ $k->deskripsi }}</p>
                                <a href="/detail/{{ $k->id }}" class="btn btn-primary">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
