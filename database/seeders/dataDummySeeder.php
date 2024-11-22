<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Form;

class dataDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Kategoris
        $kategoris = [
            ['nama' => 'Mahasiswa', 'deskripsi' => 'Formulir untuk Mahasiswa', 'user_id' => 1],
            ['nama' => 'Dosen', 'deskripsi' => 'Formulir untuk Dosen', 'user_id' => 2],
            ['nama' => 'Karyawan', 'deskripsi' => 'Formulir untuk Karyawan', 'user_id' => 3],
            ['nama' => 'Alumni', 'deskripsi' => 'Formulir untuk Alumni', 'user_id' => 4],
        ];

        // Insert kategoris and get their IDs
        $kategoriIds = [];
        foreach ($kategoris as $kategori) { 
            $kategori['slug'] = Str::of($kategori['nama'])->slug('-');
            $kategoriIds[$kategori['nama']] = DB::table('kategoris')->insertGetId($kategori);
        }

        // Templates
        $templates = [
            ['kategori_id' => $kategoriIds['Mahasiswa'], 'templates' => [
                ['nama' => 'Template Pendaftaran Mahasiswa Baru', 'user_id' => rand(1, 4)],
                ['nama' => 'Template Pengajuan Cuti Akademik', 'user_id' => rand(1, 4)],
                ['nama' => 'Template Pengajuan Beasiswa', 'user_id' => rand(1, 4)],
                ['nama' => 'Template Evaluasi Dosen', 'user_id' => rand(1, 4)],
            ]],
            ['kategori_id' => $kategoriIds['Dosen'], 'templates' => [
                ['nama' => 'Template Pengajuan Penelitian', 'user_id' => rand(1, 4)],
                ['nama' => 'Formulir Evaluasi Kinerja Dosen', 'user_id' => rand(1, 4)],
                ['nama' => 'Template Pengajuan Izin Mengajar', 'user_id' => rand(1, 4)],
                ['nama' => 'Template Pengajuan Kenaikan Pangkat', 'user_id' => rand(1, 4)],
                ['nama' => 'Template Rencana Pembelajaran Semester (RPS)', 'user_id' => rand(1, 4)],
            ]],
            ['kategori_id' => $kategoriIds['Karyawan'], 'templates' => [
                ['nama' => 'Template Pengajuan Cuti Tahunan', 'user_id' => rand(1, 4)],
                ['nama' => 'Template Laporan Kehadiran', 'user_id' => rand(1, 4)],
                ['nama' => 'Template Pengajuan Lembur', 'user_id' => rand(1, 4)],
                ['nama' => 'Template Evaluasi Kinerja Karyawan', 'user_id' => rand(1, 4)],
            ]],
            ['kategori_id' => $kategoriIds['Alumni'], 'templates' => [
                ['nama' => 'Template Pendaftaran Alumni', 'user_id' => rand(1, 4)],
                ['nama' => 'Template Pendaftaran Alumni Magister', 'user_id' => rand(1, 4)],
                ['nama' => 'Template Tracer Study Alumni', 'user_id' => rand(1, 4)],
                ['nama' => 'Template Registrasi Acara Reuni', 'user_id' => rand(1, 4)],
            ]],
        ];

        // Insert Templates and get their IDs
        $templateIds = [];
        foreach ($templates as $templateSet) {
            foreach ($templateSet['templates'] as $t) {
                $templateIds[$t['nama']] = DB::table('templates')->insertGetId([
                    'nama' => $t['nama'],
                    'slug' => Str::of($t['nama'])->slug('-'),
                    'kategori_id' => $templateSet['kategori_id'],
                    'user_id' => $t['user_id'],
                ]);
            }
        }

        // Nama Formulir
        $nama_formulir = [
            // Kategori: Mahasiswa
            ['nama' => 'Pendaftaran Program Sarjana', 'template_name' => 'Template Pendaftaran Mahasiswa Baru'],
            ['nama' => 'Pendaftaran Program Magister', 'template_name' => 'Template Pendaftaran Mahasiswa Baru'],
            ['nama' => 'Pendaftaran Program Doktoral', 'template_name' => 'Template Pendaftaran Mahasiswa Baru'],
            ['nama' => 'Pendaftaran Program Diploma', 'template_name' => 'Template Pendaftaran Mahasiswa Baru'],
            ['nama' => 'Pengajuan Cuti Semester Ganjil', 'template_name' => 'Template Pengajuan Cuti Akademik'],
            ['nama' => 'Pengajuan Cuti Semester Genap', 'template_name' => 'Template Pengajuan Cuti Akademik'],
            ['nama' => 'Pengajuan Cuti Kesehatan', 'template_name' => 'Template Pengajuan Cuti Akademik'],
            ['nama' => 'Pengajuan Cuti Khusus', 'template_name' => 'Template Pengajuan Cuti Akademik'],
            ['nama' => 'Beasiswa Prestasi Akademik', 'template_name' => 'Template Pengajuan Beasiswa'],
            ['nama' => 'Beasiswa Bantuan Sosial', 'template_name' => 'Template Pengajuan Beasiswa'],
            ['nama' => 'Beasiswa Penelitian', 'template_name' => 'Template Pengajuan Beasiswa'],
            ['nama' => 'Beasiswa Atletik', 'template_name' => 'Template Pengajuan Beasiswa'],
            ['nama' => 'Evaluasi Kinerja Dosen Semester Ganjil', 'template_name' => 'Template Evaluasi Dosen'],
            ['nama' => 'Evaluasi Kinerja Dosen Semester Genap', 'template_name' => 'Template Evaluasi Dosen'],
            ['nama' => 'Evaluasi Interaksi Dosen', 'template_name' => 'Template Evaluasi Dosen'],
            ['nama' => 'Evaluasi Kedisiplinan Dosen', 'template_name' => 'Template Evaluasi Dosen'],

            // Kategori: Dosen
            ['nama' => 'Pengajuan Penelitian Internal', 'template_name' => 'Template Pengajuan Penelitian'],
            ['nama' => 'Pengajuan Penelitian Eksternal', 'template_name' => 'Template Pengajuan Penelitian'],
            ['nama' => 'Pengajuan Penelitian Kolaboratif', 'template_name' => 'Template Pengajuan Penelitian'],
            ['nama' => 'Pengajuan Penelitian Pengembangan', 'template_name' => 'Template Pengajuan Penelitian'],
            ['nama' => 'Evaluasi Pembelajaran', 'template_name' => 'Formulir Evaluasi Kinerja Dosen'],
            ['nama' => 'Evaluasi Publikasi', 'template_name' => 'Formulir Evaluasi Kinerja Dosen'],
            ['nama' => 'Evaluasi Pengabdian Masyarakat', 'template_name' => 'Formulir Evaluasi Kinerja Dosen'],
            ['nama' => 'Evaluasi Bimbingan Akademik', 'template_name' => 'Formulir Evaluasi Kinerja Dosen'],
            ['nama' => 'Pengajuan Izin Mengajar di Luar Universitas', 'template_name' => 'Template Pengajuan Izin Mengajar'],
            ['nama' => 'Pengajuan Izin Mengajar Tambahan', 'template_name' => 'Template Pengajuan Izin Mengajar'],
            ['nama' => 'Pengajuan Izin Mengajar di Luar Negeri', 'template_name' => 'Template Pengajuan Izin Mengajar'],
            ['nama' => 'Pengajuan Izin Mengajar Online', 'template_name' => 'Template Pengajuan Izin Mengajar'],
            ['nama' => 'Pengajuan Kenaikan Pangkat Dosen Asisten Ahli', 'template_name' => 'Template Pengajuan Kenaikan Pangkat'],
            ['nama' => 'Pengajuan Kenaikan Pangkat Dosen Lektor', 'template_name' => 'Template Pengajuan Kenaikan Pangkat'],
            ['nama' => 'Pengajuan Kenaikan Pangkat Dosen Lektor Kepala', 'template_name' => 'Template Pengajuan Kenaikan Pangkat'],
            ['nama' => 'Pengajuan Kenaikan Pangkat Dosen Guru Besar', 'template_name' => 'Template Pengajuan Kenaikan Pangkat'],
            ['nama' => 'RPS Mata Kuliah Wajib', 'template_name' => 'Template Rencana Pembelajaran Semester (RPS)'],
            ['nama' => 'RPS Mata Kuliah Pilihan', 'template_name' => 'Template Rencana Pembelajaran Semester (RPS)'],
            ['nama' => 'RPS Mata Kuliah Praktikum', 'template_name' => 'Template Rencana Pembelajaran Semester (RPS)'],
            ['nama' => 'RPS Mata Kuliah Online', 'template_name' => 'Template Rencana Pembelajaran Semester (RPS)'],

            // Kategori: Karyawan
            ['nama' => 'Pengajuan Cuti Tahunan Karyawan Tetap', 'template_name' => 'Template Pengajuan Cuti Tahunan'],
            ['nama' => 'Pengajuan Cuti Tahunan Karyawan Kontrak', 'template_name' => 'Template Pengajuan Cuti Tahunan'],
            ['nama' => 'Pengajuan Cuti Hamil', 'template_name' => 'Template Pengajuan Cuti Tahunan'],
            ['nama' => 'Pengajuan Cuti Keluarga', 'template_name' => 'Template Pengajuan Cuti Tahunan'],
            ['nama' => 'Laporan Kehadiran Harian', 'template_name' => 'Template Laporan Kehadiran'],
            ['nama' => 'Laporan Kehadiran Bulanan', 'template_name' => 'Template Laporan Kehadiran'],
            ['nama' => 'Laporan Kehadiran Online', 'template_name' => 'Template Laporan Kehadiran'],
            ['nama' => 'Laporan Kehadiran Lembur', 'template_name' => 'Template Laporan Kehadiran'],
            ['nama' => 'Pengajuan Lembur Hari Kerja', 'template_name' => 'Template Pengajuan Lembur'],
            ['nama' => 'Pengajuan Lembur Akhir Pekan', 'template_name' => 'Template Pengajuan Lembur'],
            ['nama' => 'Pengajuan Lembur Malam Hari', 'template_name' => 'Template Pengajuan Lembur'],
            ['nama' => 'Pengajuan Lembur Hari Libur Nasional', 'template_name' => 'Template Pengajuan Lembur'],
            ['nama' => 'Evaluasi Kinerja Tahunan', 'template_name' => 'Template Evaluasi Kinerja Karyawan'],
            ['nama' => 'Evaluasi Kinerja Proyek', 'template_name' => 'Template Evaluasi Kinerja Karyawan'],
            ['nama' => 'Evaluasi Kinerja Tim', 'template_name' => 'Template Evaluasi Kinerja Karyawan'],
            ['nama' => 'Evaluasi Kinerja Bulanan', 'template_name' => 'Template Evaluasi Kinerja Karyawan'],

            // Kategori: Alumni
            ['nama' => 'Pendaftaran Alumni Sarjana', 'template_name' => 'Template Pendaftaran Alumni'],
            ['nama' => 'Pendaftaran Alumni Magister', 'template_name' => 'Template Pendaftaran Alumni Magister'],
            ['nama' => 'Pendaftaran Alumni Doktoral', 'template_name' => 'Template Pendaftaran Alumni'],
            ['nama' => 'Pendaftaran Alumni D3/D4', 'template_name' => 'Template Pendaftaran Alumni'],
            ['nama' => 'Pengajuan Surat Keterangan Kelulusan', 'template_name' => 'Template Pendaftaran Alumni'],
            ['nama' => 'Pengajuan Surat Keterangan Pengalaman Kerja', 'template_name' => 'Template Pendaftaran Alumni'],
            ['nama' => 'Pengajuan Surat Keterangan Alumni Aktif', 'template_name' => 'Template Pendaftaran Alumni'],
            ['nama' => 'Pengajuan Surat Keterangan Pengabdian Masyarakat', 'template_name' => 'Template Pendaftaran Alumni'],
            ['nama' => 'Tracer Study 1 Tahun Setelah Lulus', 'template_name' => 'Template Tracer Study Alumni'],
            ['nama' => 'Tracer Study 3 Tahun Setelah Lulus', 'template_name' => 'Template Tracer Study Alumni'],
            ['nama' => 'Tracer Study 5 Tahun Setelah Lulus', 'template_name' => 'Template Tracer Study Alumni'],
            ['nama' => 'Tracer Study 10 Tahun Setelah Lulus', 'template_name' => 'Template Tracer Study Alumni'],
            ['nama' => 'Registrasi Reuni Angkatan 2000-2005', 'template_name' => 'Template Registrasi Acara Reuni'],
        ];

        
        
        // Insert example questions
            DB::table('questions')->insert([
            // For Template: Formulir Pendaftaran Mahasiswa Baru
            ['template_id' => 1, 'question' => 'Nama Lengkap', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 1, 'question' => 'Program Studi Pilihan', 'type' => 'dropdown', 'options' => json_encode([
                'Teknik Informatika',
                'Sistem Informasi',
                'Manajemen',
                'Akuntansi',
                'Psikologi',
                'Hukum',
                'Ilmu Komunikasi',
                'Desain Komunikasi Visual',
                'Kedokteran',
                'Farmasi'
            ]), 'required' => true],
            ['template_id' => 1, 'question' => 'Asal Sekolah', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 1, 'question' => 'Alamat', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 1, 'question' => 'Nomor Telepon', 'type' => 'text', 'options' => null, 'required' => true],

            // For Template: Formulir Pengajuan Cuti Akademik
            ['template_id' => 2, 'question' => 'Nama Lengkap', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 2, 'question' => 'NIM', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 2, 'question' => 'Program Studi', 'type' => 'dropdown', 'options' => json_encode([
                'Teknik Informatika',
                'Sistem Informasi',
                'Manajemen',
                'Akuntansi',
                'Psikologi',
                'Hukum',
                'Ilmu Komunikasi',
                'Desain Komunikasi Visual',
                'Kedokteran',
                'Farmasi'
            ]), 'required' => true],
            ['template_id' => 2, 'question' => 'Semester Saat Ini', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 2, 'question' => 'Alasan Cuti', 'type' => 'textarea', 'options' => null, 'required' => true],

            // For Template: Formulir Pengajuan Beasiswa
            ['template_id' => 3, 'question' => 'Nama Lengkap', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 3, 'question' => 'NIM', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 3, 'question' => 'Program Studi', 'type' => 'dropdown', 'options' => json_encode([
                'Teknik Informatika',
                'Sistem Informasi',
                'Manajemen',
                'Akuntansi',
                'Psikologi',
                'Hukum',
                'Ilmu Komunikasi',
                'Desain Komunikasi Visual',
                'Kedokteran',
                'Farmasi'
            ]), 'required' => true],
            ['template_id' => 3, 'question' => 'IPK Terakhir', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 3, 'question' => 'Surat Rekomendasi Dosen', 'type' => 'file', 'options' => null, 'required' => true],

            // For Template: Formulir Evaluasi Dosen
            ['template_id' => 4, 'question' => 'Nama Dosen', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 4, 'question' => 'Mata Kuliah', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 4, 'question' => 'Semester', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 4, 'question' => 'Kualitas Pengajaran (Skala 1-5)', 'type' => 'number', 'options' => json_encode(['min' => 1, 'max' => 5]), 'required' => true],
            ['template_id' => 4, 'question' => 'Kritik & Saran', 'type' => 'textarea', 'options' => null, 'required' => false],

            // For Template: Formulir Pengajuan Penelitian
            ['template_id' => 5, 'question' => 'Nama Lengkap', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 5, 'question' => 'Judul Penelitian', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 5, 'question' => 'Bidang Studi', 'type' => 'dropdown', 'options' => json_encode([
                'Teknik Informatika',
                'Sistem Informasi',
                'Manajemen',
                'Akuntansi',
                'Psikologi',
                'Hukum',
                'Ilmu Komunikasi',
                'Desain Komunikasi Visual',
                'Kedokteran',
                'Farmasi'
            ]), 'required' => true],
            ['template_id' => 5, 'question' => 'Rencana Anggaran', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 5, 'question' => 'Nama Pembimbing', 'type' => 'text', 'options' => null, 'required' => true],

            // For Template: Formulir Evaluasi Kinerja Dosen
            ['template_id' => 6, 'question' => 'Nama Dosen', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 6, 'question' => 'Mata Kuliah', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 6, 'question' => 'Semester', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 6, 'question' => 'Penguasaan Materi (Skala 1-5)', 'type' => 'number', 'options' => json_encode(['min' => 1, 'max' => 5]), 'required' => true],
            ['template_id' => 6, 'question' => 'Kepuasan Mahasiswa (Skala 1-5)', 'type' => 'number', 'options' => json_encode(['min' => 1, 'max' => 5]), 'required' => true],

            // For Template: Formulir Pengajuan Izin Mengajar
            ['template_id' => 7, 'question' => 'Nama Dosen', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 7, 'question' => 'Institusi Tujuan', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 7, 'question' => 'Mata Kuliah yang Diajarkan', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 7, 'question' => 'Tanggal Izin', 'type' => 'date', 'options' => null, 'required' => true],
            ['template_id' => 7, 'question' => 'Durasi Izin', 'type' => 'text', 'options' => null, 'required' => true],

            // For Template: Formulir Pengajuan Kenaikan Pangkat
            ['template_id' => 8, 'question' => 'Nama Dosen', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 8, 'question' => 'Jabatan Akademik Saat Ini', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 8, 'question' => 'Jabatan Akademik yang Diajukan', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 8, 'question' => 'Dokumen Pendukung', 'type' => 'file', 'options' => null, 'required' => true],

            // For Template: Formulir Rencana Pembelajaran Semester (RPS)
            ['template_id' => 9, 'question' => 'Mata Kuliah', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 9, 'question' => 'Semester', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 9, 'question' => 'Deskripsi Mata Kuliah', 'type' => 'textarea', 'options' => null, 'required' => true],
            ['template_id' => 9, 'question' => 'Tujuan Pembelajaran', 'type' => 'textarea', 'options' => null, 'required' => true],
            ['template_id' => 9, 'question' => 'Metode Pembelajaran', 'type' => 'textarea', 'options' => null, 'required' => true],

            // For Template: Formulir Pengajuan Cuti Tahunan
            ['template_id' => 10, 'question' => 'Nama Lengkap', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 10, 'question' => 'NIP', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 10, 'question' => 'Tanggal Cuti', 'type' => 'date', 'options' => null, 'required' => true],
            ['template_id' => 10, 'question' => 'Durasi Cuti', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 10, 'question' => 'Alasan Cuti', 'type' => 'textarea', 'options' => null, 'required' => true],

            // For Template: Formulir Laporan Kehadiran
            ['template_id' => 11, 'question' => 'Nama Dosen', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 11, 'question' => 'Mata Kuliah', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 11, 'question' => 'Tanggal Kehadiran', 'type' => 'date', 'options' => null, 'required' => true],
            ['template_id' => 11, 'question' => 'Jumlah Kehadiran', 'type' => 'number', 'options' => json_encode(['min' => 0]), 'required' => true],

            // For Template: Formulir Pengajuan Lembur
            ['template_id' => 12, 'question' => 'Nama Lengkap', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 12, 'question' => 'Jabatan', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 12, 'question' => 'Tanggal Lembur', 'type' => 'date', 'options' => null, 'required' => true],
            ['template_id' => 12, 'question' => 'Durasi Lembur', 'type' => 'text', 'options' => null, 'required' => true],

            // For Template: Formulir Evaluasi Kinerja Karyawan
            ['template_id' => 13, 'question' => 'Nama Karyawan', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 13, 'question' => 'Jabatan', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 13, 'question' => 'Kinerja (Skala 1-5)', 'type' => 'number', 'options' => json_encode(['min' => 1, 'max' => 5]), 'required' => true],
            ['template_id' => 13, 'question' => 'Kritik & Saran', 'type' => 'textarea', 'options' => null, 'required' => false],

            // For Template: Formulir Pendaftaran Alumni
            ['template_id' => 14, 'question' => 'Nama Lengkap', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 14, 'question' => 'NIM', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 14, 'question' => 'Program Studi', 'type' => 'dropdown', 'options' => json_encode([
                'Teknik Informatika',
                'Sistem Informasi',
                'Manajemen',
                'Akuntansi',
                'Psikologi',
                'Hukum',
                'Ilmu Komunikasi',
                'Desain Komunikasi Visual',
                'Kedokteran',
                'Farmasi'
            ]), 'required' => true],
            ['template_id' => 14, 'question' => 'Tahun Lulus', 'type' => 'text', 'options' => null, 'required' => true],

            // For Template: Formulir Pengajuan Surat Keterangan Alumni
            ['template_id' => 15, 'question' => 'Nama Lengkap', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 15, 'question' => 'NIM', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 15, 'question' => 'Program Studi', 'type' => 'dropdown', 'options' => json_encode([
                'Teknik Informatika',
                'Sistem Informasi',
                'Manajemen',
                'Akuntansi',
                'Psikologi',
                'Hukum',
                'Ilmu Komunikasi',
                'Desain Komunikasi Visual',
                'Kedokteran',
                'Farmasi'
            ]), 'required' => true],
            ['template_id' => 15, 'question' => 'Kepentingan Surat Keterangan', 'type' => 'text', 'options' => null, 'required' => true],

            // For Template: Formulir Tracer Study Alumni
            ['template_id' => 16, 'question' => 'Nama Lengkap', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 16, 'question' => 'NIM', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 16, 'question' => 'Program Studi', 'type' => 'dropdown', 'options' => json_encode([
                'Teknik Informatika',
                'Sistem Informasi',
                'Manajemen',
                'Akuntansi',
                'Psikologi',
                'Hukum',
                'Ilmu Komunikasi',
                'Desain Komunikasi Visual',
                'Kedokteran',
                'Farmasi'
            ]), 'required' => true],
            ['template_id' => 16, 'question' => 'Status Pekerjaan Saat Ini', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 16, 'question' => 'Penghasilan Saat Ini', 'type' => 'text', 'options' => null, 'required' => true],

            // For Template: Formulir Registrasi Acara Reuni
            ['template_id' => 17, 'question' => 'Nama Lengkap', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 17, 'question' => 'NIM', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 17, 'question' => 'Tahun Lulus', 'type' => 'text', 'options' => null, 'required' => true],
            ['template_id' => 17, 'question' => 'Kehadiran pada Acara Reuni', 'type' => 'radio', 'options' => json_encode(['Hadir', 'Tidak Hadir']), 'required' => true],

        ]);

        // Membuat Data Form
        foreach ($nama_formulir as $form) {
            $templateId = $templateIds[$form['template_name']] ?? null;
            if ($templateId) {
                $slug = Str::of($form['nama'])->slug('-');
                $tautan = "http://pkl-project.test:8080/detail/answer/" . $slug;

                Form::create([
                    'nama' => $form['nama'],
                    'slug' => $slug,
                    'tautan' => $tautan,
                    'template_id' => $templateId,
                    'user_id' => rand(1, 4),
                    'tahun_ajaran' => now()->year,
                    'open' => now(),
                    'tipe' => 'default_value',
                    'close' => now()->addDays(10),
                ]);
            }
        }
    }

}
