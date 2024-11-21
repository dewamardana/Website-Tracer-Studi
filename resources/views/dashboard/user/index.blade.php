    @extends('dashboard.Layout.main')

    @section('main')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Selamat Datang {{ $username }}</h1>
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
        <div class="table-responsive">
            <table class="table table-striped table-sm">
            <thead>
                <tr>
                <th scope="col">No</th>
                <th scope="col">Nama User</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $index => $u)
                <tr>
                <td>{{ $index+1 }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ implode(', ', $u->role ?? []) }}</td> 
                <td>
                    <a href="/dashboard/user/{{ $u->id }}/edit" class="badge bg-warning"><span data-feather="edit"></span></a>
                    <a href="/dashboard/user/{{ $u->id }}" class="badge bg-info"><span data-feather="eye"></span></a>
                </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    @endsection