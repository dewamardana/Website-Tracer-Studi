@extends('dashboard.Layout.main')

@section('main')
<div class="container mt-4">
    <h3>Analytics Pengguna</h3>
    
    <div class="row">
        <!-- Kotak pertama untuk jumlah pengguna terdaftar dengan background abu-abu -->
        <div class="col-md-4">
            <div class="card bg-light"> <!-- bg-light untuk background abu-abu muda -->
                <div class="card-body">
                    <!-- Flexbox untuk menempatkan ikon di sebelah kiri dan teks di sebelah kanan -->
                    <div class="d-flex align-items-center" style="gap: 130px;"> <!-- Menambahkan gap untuk jarak -->
                        <!-- Ikon profil dengan warna biru di sebelah kiri -->
                        <i class="bi bi-person-circle" style="font-size: 3rem; color: #007bff;"></i>
                        
                        <!-- Teks di sebelah kanan dengan rata kanan -->
                        <div class="text-end"> <!-- Menggunakan text-end untuk meratakan teks ke kanan -->
                            <h4>{{ $jumlahUsers }}</h4>
                            <p class="card-text">Pengguna Terdaftar</p>
                        </div>
                    </div>
                    <!-- Progress bar di bawah teks -->
                    <div class="progress mt-2" style="height: 10px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ ($jumlahUsers / 1000) * 100 }}%;" aria-valuenow="{{ $jumlahUsers }}" aria-valuemin="0" aria-valuemax="1000"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kotak kedua untuk jumlah jawaban form dengan background abu-abu -->
        <div class="col-md-4">
            <div class="card bg-light"> <!-- bg-light untuk background abu-abu muda -->
                <div class="card-body">
                    <!-- Flexbox untuk menempatkan ikon di sebelah kiri dan teks di sebelah kanan -->
                    <div class="d-flex align-items-center" style="gap: 150px;"> <!-- Menambahkan gap untuk jarak -->
                        <!-- Ikon ir dengan warna hijau di sebelah kiri -->
                        <i class="bi bi-file-earmark-text" style="font-size: 3rem; color: #28a745;"></i>
                        
                        <!-- Teks di sebelah kanan dengan rata kanan -->
                        <div class="text-end"> <!-- Menggunakan text-end untuk meratakan teks ke kanan -->
                            <h4>{{ $jumlahJawaban }}</h4>
                            <p class="card-text">Jawaban Form</p>
                        </div>
                    </div>
                    <!-- Progress bar di bawah teks -->
                    <div class="progress mt-2" style="height: 10px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($jumlahJawaban / 1000) * 100 }}%;" aria-valuenow="{{ $jumlahJawaban }}" aria-valuemin="0" aria-valuemax="1000"></div>
                    </div>
                </div>
            </div>
            </div>
              
          

             <!-- Kotak kedua untuk jumlah jawaban form dengan background abu-abu -->
        <div class="col-md-4">
            <div class="card bg-light"> <!-- bg-light untuk background abu-abu muda -->
                <div class="card-body">
                    <!-- Flexbox untuk menempatkan ikon di sebelah kiri dan teks di sebelah kanan -->
                    <div class="d-flex align-items-center" style="gap: 160px;"> <!-- Menambahkan gap untuk jarak -->

                       <!-- Ikon grafik dengan warna oranye di sebelah kiri -->
                       <i class="bi-clock" style="font-size: 3rem; color: #ff8c00;"></i> <!-- Ganti dengan ikon grafik -->

                       <div class="text-end"> <!-- Menggunakan text-end untuk meratakan teks ke kanan -->
    <h4 id="digitalClock"></h4>
    <p class="card-text">Waktu Sekarang</p>
</div>

<script>
    // Fungsi untuk memperbarui waktu setiap detik
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        // Format waktu menjadi HH:mm:ss
        const timeString = `${hours}:${minutes}:${seconds}`;
        
        // Menampilkan waktu di elemen dengan id "digitalClock"
        document.getElementById('digitalClock').textContent = timeString;
    }

    // Perbarui waktu setiap detik
    setInterval(updateClock, 1000);

    // Panggil fungsi sekali saat halaman dimuat
    updateClock();
</script>

                    <!-- Progress bar di bawah teks -->
                    <div class="progress mt-2" style="height: 10px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($jumlahJawaban / 1000) * 100 }}%;" aria-valuenow="{{ $jumlahJawaban }}" aria-valuemin="0" aria-valuemax="1000"></div>
                    </div>
                </div>
            </div>
                </div>
                    </tbody>
                </table>

            </div>

        </div>

    
    

                
        <div class="relative mt-4 d-flex flex-column gap-3">
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        @include('livewire.table-form')
                    </div>
                </div>
                {{-- <p>Jumlah user yang telah mengisi: {{ $form->user_count }}</p> --}}
            </div>
        </div>
    </div>
@endsection

