@extends('dashboard.Layout.main')

@section('main')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Haii {{ $user }}</h1>
  </div>
    @if (session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
  @endif
  <a href="/dashboard/menuform/form/create" class="btn btn-primary mt-2 mb-2">New Formulir</a>
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
                <a href="/dashboard/menuform/{{ $t->id }}" class="badge bg-success"><span data-feather="eye"></span></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
@endsection