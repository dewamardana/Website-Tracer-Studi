<form action="{{ route('analytics.index') }}" method="GET">
    <div class="input-group mb-3">
        <!-- Dropdown kategori -->
        <select name="tipe" class="form-select" onchange="this.form.submit()">
        <option selected disabled>Pilih Kategori</option>
            @foreach ($kategori as $k)
                <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                
            @endforeach
        </select>
        @error('kategori_id')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <!-- Input pencarian -->
        <input type="text" name="search" class="form-control" placeholder="Cari Form"
               value="{{ $searchQuery }}">

        <!-- Tombol cari -->
        <button class="btn btn-primary" type="submit">Cari</button>
    </div>
</form>

<table class="table">
        <thead>
            <tr>
                <th scope="col">Id Form</th>
                <th scope="col">Form</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Analytics</th>
            </tr>
        </thead>
        <tbody>
            @if($forms->isEmpty())
                <tr>
                    <td colspan="4" class="text-center">Tidak ada hasil ditemukan untuk pencarian "{{ request()->input('search') }}"</td>
                </tr>
            @else
                @foreach ($forms as $form)
                    <tr>
                        <th scope="row">{{ $form->id }}</th>
                        <td>{{ $form->nama}}</td>
                        <td>{{ $form->jumlah_responden }}</td>
                     
                        <td><a href="{{ route('analytics.view', ['formNama' => $form->nama]) }}" style="text-decoration: none">Lihat</a></td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {{ $forms->links('pagination::bootstrap-5') }}
</div>
