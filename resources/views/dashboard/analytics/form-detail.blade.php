@extends('dashboard.Layout.main')

@section('main')
<div class="container mt-4">
    <h1>Form</h1>
    @if($forms->isEmpty())
        <p>Tidak ada form yang ditemukan.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID Form</th>
                    <th scope="col">Nama Form</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($forms as $form)
                <tr>
                    <th scope="row">{{ $form->id }}</th>
                    <td>{{ $form->nama }}</td>
                    <td>
                        <a href="{{ route('form.detail', ['id' => $form->id]) }}" class="btn btn-info">Lihat Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
