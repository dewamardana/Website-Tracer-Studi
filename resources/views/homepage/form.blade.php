@extends('template.index')

@section('content')

@if (session('success'))
    <div class="alert alert-success mt-1" role="alert">
        {{ session('success') }}
    </div>
@elseif (session('warning'))
    <div class="alert alert-warning mt-1" role="alert">
        {{ session('warning') }}
    </div>
@endif

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Buat Formulir</h1>
</div>
<a href="/detail/{{ $kategori }}" class="btn btn-success mt-2 mb-2">Kembali</a>

    <div class="table-responsive">
        <table class="table table-sm">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama Formulir</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($form as $index => $f)
            <tr>
              <td>{{ $index+1 }}</td>
              <td>{{ $f->nama }}</td>
              <td><a href="/detail/answer/{{ $f->slug }}" class="badge bg-primary"><span data-feather="edit"></a>
            </tr>
            @endforeach
          </tbody>
        </table>
    </div>
@endsection
