@extends('dashboard.Layout.main')

@section('main')
<a href="/dashboard/form" class="btn btn-success mt-2 mb-2">Kembali</a>
<div class="d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Buat Formulir</h1>
</div>

<form method="POST" action="/dashboard/form">
    @csrf
    <div class="row">
        <div class="col col-lg-6">            
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Formulir</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                value="{{ old('nama') }}" required>
                @error('nama')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="template_id" class="form-label">Template</label>
                <select class="form-select form-select-lg mb-3 @error('template_id') is-invalid @enderror" aria-label="Large select example" id="template_id" name="template_id" required>
                    <option selected disabled>Pilih Template</option>
                    @foreach ($template as $t)
                        <option value="{{ $t->id }}" {{ old('template_id') == $t->id ? 'selected' : '' }}>{{ $t->nama }}</option>
                    @endforeach
                </select>
                @error('template_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <fieldset disabled>
                <div class="mb-3">
                    <label for="tautan" class="form-label">Link Akses</label>
                    <input type="text" id="tautan" class="form-control" name="tautan" value="{{ old('tautan') }}"> 
                </div>
            </fieldset disabled>
        </div>
        <div class="col col-lg-6">
            <div class="mb-3">
                <label for="tahun_ajaran" class="form-label">Tahun ajaran</label>
                <input type="number" class="form-control @error('tahun_ajaran') is-invalid @enderror" id="tahun_ajaran" name="tahun_ajaran"
                value="{{ old('tahun_ajaran') }}" required>
                @error('tahun_ajaran')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="open" class="form-label">Dibuka Mulai</label>
                <input type="date" class="form-control @error('open') is-invalid @enderror" id="open" name="open"
                value="{{ old('open') }}" required>
                @error('open')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="close" class="form-label">Ditutup Pada</label>
                <input type="date" class="form-control @error('close') is-invalid @enderror" id="close" name="close"
                value="{{ old('close') }}" required>
                @error('close')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Buat</button>
</form>
@endsection

