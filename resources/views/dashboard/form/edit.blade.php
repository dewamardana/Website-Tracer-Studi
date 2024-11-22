@extends('dashboard.Layout.main')

<<<<<<< HEAD
@section('main')
@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <div class="alert alert-primary" role="alert">
                    <li>{{ $error }}</li>
                </div>
            @endforeach
        </ul>
    </div>
@endif

=======
@section('main') 
>>>>>>> 250ab6d41aa9fde7ed758faa268346ec9e2b0f5b
<a href="/dashboard/form" class="btn btn-success mt-2 mb-2">Kembali</a>
<div class="d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Formulir</h1>
</div>

<<<<<<< HEAD
<form method="POST" action="/dashboard/form{{ $form->slug }}">
=======
<form method="POST" action="/dashboard/form/{{ $form->slug }}">
>>>>>>> 250ab6d41aa9fde7ed758faa268346ec9e2b0f5b
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col col-lg-6">            
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Formulir</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
<<<<<<< HEAD
                value="{{ old('nama') }}" required>
=======
                value="{{ old('nama', $form->nama) }}" required>
>>>>>>> 250ab6d41aa9fde7ed758faa268346ec9e2b0f5b
                @error('nama')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
<<<<<<< HEAD
=======

>>>>>>> 250ab6d41aa9fde7ed758faa268346ec9e2b0f5b
            
            <div class="mb-3">
                <label for="template_id" class="form-label">Template</label>
                <select class="form-select form-select-lg mb-3 @error('template_id') is-invalid @enderror" aria-label="Large select example" id="template_id" name="template_id" required>
                    <option selected disabled>Pilih Template</option>
                    @foreach ($template as $t)
<<<<<<< HEAD
                        <option value="{{ $t->id }}" {{ old('template_id') == $t->id ? 'selected' : '' }}>{{ $t->nama }}</option>
=======
                        <option value="{{ $t->id }}" {{ old('template_id', $form->template_id) == $t->id ? 'selected' : '' }}>{{ $t->nama }}</option>
>>>>>>> 250ab6d41aa9fde7ed758faa268346ec9e2b0f5b
                    @endforeach
                </select>
                @error('template_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <fieldset disabled>
                <div class="mb-3">
                    <label for="tautan" class="form-label">Link Akses</label>
<<<<<<< HEAD
                    <input type="text" id="tautan" class="form-control" name="tautan" value="{{ old('tautan') }}"> 
=======
                    <input type="text" id="tautan" class="form-control" name="tautan" value="{{ old('tautan', $form->tautan) }}"> 
>>>>>>> 250ab6d41aa9fde7ed758faa268346ec9e2b0f5b
                </div>
            </fieldset disabled>
        </div>
        <div class="col col-lg-6">
            <div class="mb-3">
                <label for="tahun_ajaran" class="form-label">Tahun ajaran</label>
                <input type="number" class="form-control @error('tahun_ajaran') is-invalid @enderror" id="tahun_ajaran" name="tahun_ajaran"
<<<<<<< HEAD
                value="{{ old('tahun_ajaran') }}" required>
=======
                value="{{ old('tahun_ajaran', $form->tahun_ajaran) }}" required>
>>>>>>> 250ab6d41aa9fde7ed758faa268346ec9e2b0f5b
                @error('tahun_ajaran')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="open" class="form-label">Dibuka Mulai</label>
                <input type="date" class="form-control @error('open') is-invalid @enderror" id="open" name="open"
<<<<<<< HEAD
                value="{{ old('open') }}" required>
=======
                value="{{ old('open', $form->open) }}" required>
>>>>>>> 250ab6d41aa9fde7ed758faa268346ec9e2b0f5b
                @error('open')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="close" class="form-label">Ditutup Pada</label>
                <input type="date" class="form-control @error('close') is-invalid @enderror" id="close" name="close"
<<<<<<< HEAD
                value="{{ old('close') }}" required>
=======
                value="{{ old('close', $form->close) }}" required>
>>>>>>> 250ab6d41aa9fde7ed758faa268346ec9e2b0f5b
                @error('close')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
<<<<<<< HEAD
    <button type="submit" class="btn btn-primary">Buat</button>
</form>
<script>
    document.getElementById('tautan').addEventListener('input', function() {
        var namaFormulir = this.value.trim();
        var linkAkses = 'http://pkl-project.test:8080/detail/answer/' + encodeURIComponent(namaFormulir);
        document.getElementById('tautan').value = linkAkses;
    });
</script>
=======
    <button type="submit" class="btn btn-warning">Edit</button>
</form>
>>>>>>> 250ab6d41aa9fde7ed758faa268346ec9e2b0f5b
@endsection

