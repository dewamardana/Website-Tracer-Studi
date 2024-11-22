@extends('dashboard.Layout.main')

@section('main') 
<a href="/dashboard/user" class="btn btn-success mt-2 mb-2">Kembali</a>
<div class="d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Role</h1>
</div>

<form method="POST" action="/dashboard/user/{{ $user->id }}">
    @csrf
    @method('PUT')
    <div class="row justify-content-center border border-secondary border-2 rounded" style="width: 50%; margin: 0 auto;">
        <div class="col p-5">            
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="name" value="{{ $user->name }}" disabled>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <div>
                    @php
                        $roles = ['admin', 'dosen', 'mahasiswa'];
                    @endphp
                    @foreach ($roles as $role)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                id="role-{{ $role }}" 
                                name="role[]" 
                                value="{{ $role }}" 
                                {{ in_array($role, $user->role) ? 'checked' : '' }}>
                            <label class="form-check-label" for="role-{{ $role }}">
                                {{ ucfirst($role) }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="btn btn-warning">Edit</button>
        </div>
    </div>
</form>

@endsection

