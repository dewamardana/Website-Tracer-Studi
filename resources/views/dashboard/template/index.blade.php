@extends('dashboard.Layout.main')

@section('main')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Haii {{ $user }}</h1>
  </div>
  @if (session('status'))
  <div class="alert alert-success mt-1" role="alert">
    {{ session('status') }}
  </div>
  @endif
  <a href="/dashboard/template/create" class="btn btn-primary mt-2 mb-2">New Template</a>
        <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama</th>
              <th scope="col">Deskripsi</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($template as $index => $t)
            <tr>
              <td>{{ $index+1 }}</td>
              <td>{{ $t->nama }}</td>
              <td>{{ $t->deskripsi }}</td>
              <td>
                <a href="/dashboard/template/{{ $t->id }}/edit" class="badge bg-warning"><span data-feather="edit"></span></a>
                <form action="/dashboard/template/{{ $t->id }}" class="d-inline" method="POST">
                  @csrf
                  @method('DELETE')
                  <button class="badge bg-danger border-0" onclick="return confirm('Konfirmasi Menghapus Template')"><span data-feather="x-circle"></span></button>
                </form>
                </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
@endsection