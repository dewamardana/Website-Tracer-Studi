@extends('dashboard.Layout.main')

@section('main')
<<<<<<< HEAD
  @if (session('status'))
  <div class="alert alert-success mt-1" role="alert">
    {{ session('status') }}
  </div>
  @endif
=======
    @if (session('success'))
        <div class="alert alert-success mt-1" role="alert">
            {{ session('success') }}
        </div>
    @elseif (session('warning'))
        <div class="alert alert-warning mt-1" role="alert">
            {{ session('warning') }}
        </div>
    @endif

>>>>>>> 250ab6d41aa9fde7ed758faa268346ec9e2b0f5b
  <a href="/dashboard/form/create" class="btn btn-primary mt-2 mb-2">Buat Formulir</a>
                
     <div class="section-title text-center">
        <p class="fs-1 fw-bold"><span>Semua</span> Formulir</p>
    </div>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
            <thead>
                <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Formulir</th>
                <th scope="col">Nama Template</th>
                <th scope="col">Pembuat</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($form as $index => $f)
                <tr class="{{ Auth::user()->id == $f->user_id ? 'table-success' : '' }}">
                <td>{{ $index+1 }}</td>
                <td>{{ $f->nama }}</td>
                <td>{{ $f->template->nama }}</td>
                <td>{{ $f->user->name }}</td>
                <td>
                    <a href="/dashboard/form/{{ $f->slug }}/edit" class="badge bg-warning"><span data-feather="edit"></span></a>
                    <a href="/dashboard/form/{{ $f->slug }}" class="badge bg-info"><span data-feather="eye"></span></a>
                    <form action="/dashboard/form/{{ $f->slug }}" class="d-inline" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="badge bg-danger border-0" onclick="return confirm('Konfirmasi Menghapus Formulir ?')"><span data-feather="x-circle"></span></button>
                    </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
      </div>
@endsection