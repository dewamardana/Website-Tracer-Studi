@extends('dashboard.Layout.main')

@section('main')
<a href="/dashboard/form" class="btn btn-success mt-2 mb-2">Kembali</a>
<div class="d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Formulir</h1>
</div>

    <div class="row">
        <div class="col col-lg-6"> 
            <fieldset disabled>           
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Formulir</label>
                    <input type="text" class="form-control" id="nama" value="{{ $form->nama }}">
                </div>
                
                <div class="mb-3">
                    <label for="template" class="form-label">Nama template</label>
                    <input type="text" class="form-control" id="template" value="{{ $form->template->nama }}">
                </div>
                <div class="mb-3">
                    <label for="tautan" class="form-label">Link Akses</label>
                    <input type="text" class="form-control" id="tautan" value="{{ $form->tautan}}">
                </div>
            </fieldset disabled>
        </div>
        <div class="col col-lg-6">
            <fieldset disabled>
                <div class="mb-3">
                    <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                    <input type="text" class="form-control" id="tahun_ajaran" value="{{ $form->tahun_ajaran }}">
                </div>
                <div class="mb-3">
                    <label for="open" class="form-label">Dibuka Mulai</label>
                    <input type="date" class="form-control" id="open" value="{{ $form->open }}">
                </div>
                <div class="mb-3">
                    <label for="close" class="form-label">Ditutup Pada</label>
                    <input type="date" class="form-control" id="close" value="{{ $form->close }}">
                </div>
            </fieldset disabled>
        </div>
    </div>


@endsection

