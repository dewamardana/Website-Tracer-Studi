@extends('dashboard.Layout.main')

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

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Buat Formulir</h1>
</div>
<a href="/dashboard/menutemplate" class="btn btn-success mt-2 mb-2">Kembali</a>

    <div class="table-responsive">
        <table class="table table-sm">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama Template</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($template as $index => $t)
            <tr class="{{ Auth::user()->id == $t->user_id ? 'table-success' : '' }}">
              <td>{{ $index+1 }}</td>
              <td>{{ $t->nama }}</td>
<<<<<<< HEAD
              <td><a href="/dashboard/menutemplate/template/copy/{{ $t->id }}" class="badge bg-primary"><span data-feather="edit"></span></a></td>
=======
              <td><a href="/dashboard/menutemplate/template/copy/{{ $t->slug }}" class="badge bg-primary"><span data-feather="edit"></span></a></td>
>>>>>>> 250ab6d41aa9fde7ed758faa268346ec9e2b0f5b
            </tr>
            @endforeach
          </tbody>
        </table>
    </div>
@endsection
