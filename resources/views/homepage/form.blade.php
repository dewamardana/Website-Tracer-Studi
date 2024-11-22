@extends('template.index')

@section('content')

<!-- Notifikasi -->
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@elseif (session('warning'))
    <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@elseif (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        <i class="bi bi-x-circle-fill"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Header -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2">📄 Data Formulir</h1>
</div>
<a href="/detail/{{ $kategori }}" class="btn btn-success mb-3 ms-2"><i class="bi bi-arrow-left"></i> Kembali</a>

<!-- Tabel Formulir -->
<div class="table-responsive rounded shadow-sm mx-2">
    <table class="table table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th scope="col" style="width: 5%">No</th>
                <th scope="col">Nama Formulir</th>
                <th scope="col" style="width: 15%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($form as $index => $f)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $f->nama }}</td>
                    <td>
                        <a href="/detail/answer/{{ $f->slug }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil-square"></i> Isi Formulir
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
