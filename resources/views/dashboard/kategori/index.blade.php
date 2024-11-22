    @extends('dashboard.Layout.main')

    @section('main')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Haii {{ $user }}</h1>
    </div>
    @if (session('success'))
        <div class="alert alert-success mt-1" role="alert">
            {{ session('success') }}
        </div>
    @elseif (session('warning'))
        <div class="alert alert-warning mt-1" role="alert">
            {{ session('warning') }}
        </div>
    @endif

    <a href="/dashboard/kategori/create" class="btn btn-primary mt-2 mb-2">Kategori Baru</a>
            <div class="table-responsive">
            <table class="table table-striped table-sm">
            <thead>
                <tr>
                <th scope="col">No</th>
                <th scope="col">Nama kategori</th>
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
                    <a href="/dashboard/kategori/{{ $k->slug }}/edit" class="badge bg-warning"><span data-feather="edit"></span></a>
                    <form action="/dashboard/kategori/{{ $k->slug }}" class="d-inline" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="badge bg-danger border-0" onclick="return confirm('Konfirmasi Menghapus Kategori')"><span data-feather="x-circle"></span></button>
                    </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    @endsection
