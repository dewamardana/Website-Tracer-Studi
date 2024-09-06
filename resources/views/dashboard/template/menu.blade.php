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
  <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newTemplate">
     Buat Template
    </button>

    <!-- Modal -->
    <div class="modal fade" id="newTemplate" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">Buat Template</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Buat Template Baru atau Salin dari Template yang sudah ada
          </div>
          <div class="modal-footer">
            <a href="/dashboard/menutemplate/template/create" class="btn btn-primary mt-2 mb-2">Baru</a>
            <a href="/dashboard/menutemplate/template/copy" class="btn btn-primary mt-2 mb-2">Salin</a>
          </div>
        </div>
      </div>
    </div>
        <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama Kategori</th>
              <th scope="col">Deskripsi</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($kategori as $index => $k)
            <tr>
              <td>{{ $index+1 }}</td>
              <td>{{ $k->nama }}</td>
              <td>{{ $k->deskripsi }}</td>
              <td>
                <a href="/dashboard/menutemplate/{{ $k->slug }}" class="badge bg-success"><span data-feather="eye"></span></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
@endsection