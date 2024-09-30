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

@if(session('showModal'))
<!-- Modal -->
<div class="modal fade" id="newTemplate" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Peringatan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>{{ session('modalTitle') }}</h4>
                <p>{{ session('modalMessage') }}</p>
            </div>
            <div class="modal-footer">
              <a href="{{ route('duplicateTemplate', ['id' => session('id')]) }}" class="btn btn-primary mt-2 mb-2">OK</a>
              <button type="button" class="btn btn-success" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
@endif

  <a href="/dashboard/menutemplate" class="btn btn-success mt-2 mb-2">Kembali</a>
        <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama Kategori</th>
              <th scope="col">Nama Template</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($template as $index => $t)
            <tr class="{{ Auth::user()->id == $t->user_id ? 'table-success' : '' }}">
              <td>{{ $index+1 }}</td>
              <td>{{ $t->kategori->nama }}</td>
              <td>{{ $t->nama }}</td>
              <td>
                <a href="/dashboard/menutemplate/template/{{ $t->slug }}/check" class="badge bg-warning"><span data-feather="edit"></span></a>
                <a href="/dashboard/menutemplate/template/{{ $t->slug }}" class="badge bg-info"><span data-feather="eye"></span></a>
                <form action="/dashboard/menutemplate/template/{{ $t->slug }}" class="d-inline" method="POST">
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
    @if(session('showModal'))
      <script>
          document.addEventListener('DOMContentLoaded', () => {
              const modal = new bootstrap.Modal(document.getElementById('newTemplate'));
              modal.show();
          });
      </script>
  @endif
@endsection