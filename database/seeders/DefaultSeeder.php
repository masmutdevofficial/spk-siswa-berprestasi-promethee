<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DefaultSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Yayasan
        DB::table('admin_yayasan')->insert([
            [
                'admin_yayasan_id' => 1,
                'username' => 'yayasanadmin1',
                'email' => 'yayasan1@example.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'admin_yayasan_id' => 2,
                'username' => 'yayasanadmin2',
                'email' => 'yayasan2@example.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Yayasan
        DB::table('yayasan')->insert([
            [
                'yayasan_id' => 1,
                'nama_yayasan' => 'Yayasan Cahaya Bangsa',
                'alamat' => 'Jl. Merdeka No. 1, Jakarta',
                'admin_yayasan_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'yayasan_id' => 2,
                'nama_yayasan' => 'Yayasan Pelita Harapan',
                'alamat' => 'Jl. Pelajar No. 2, Bandung',
                'admin_yayasan_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Sekolah
        DB::table('sekolah')->insert([
            [
                'sekolah_id' => 1,
                'yayasan_id' => 1,
                'nama_sekolah' => 'SD Unggul Cahaya',
                'alamat' => 'Jl. Kenanga 10, Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sekolah_id' => 2,
                'yayasan_id' => 1,
                'nama_sekolah' => 'SMP Unggul Cahaya',
                'alamat' => 'Jl. Melati 12, Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sekolah_id' => 3,
                'yayasan_id' => 2,
                'nama_sekolah' => 'SMA Pelita Harapan',
                'alamat' => 'Jl. Anggrek 5, Bandung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Admin Sekolah
        DB::table('admin_sekolah')->insert([
            [
                'admin_sekolah_id' => 1,
                'username' => 'sekolahadmin1',
                'email' => 'admin1@sekolah.com',
                'password' => Hash::make('password'),
                'sekolah_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'admin_sekolah_id' => 2,
                'username' => 'sekolahadmin2',
                'email' => 'admin2@sekolah.com',
                'password' => Hash::make('password'),
                'sekolah_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Guru
        DB::table('user_guru')->insert([
            [
                'user_guru_id' => 1,
                'sekolah_id' => 1,
                'username' => 'guru1',
                'email' => 'guru1@sekolah.com',
                'password' => Hash::make('password'),
                'nama' => 'Budi Santoso',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_guru_id' => 2,
                'sekolah_id' => 2,
                'username' => 'guru2',
                'email' => 'guru2@sekolah.com',
                'password' => Hash::make('password'),
                'nama' => 'Siti Aminah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Kelas
        DB::table('kelas')->insert([
            [
                'kelas_id' => 1,
                'sekolah_id' => 1,
                'nama_kelas' => 'Kelas 1A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 2,
                'sekolah_id' => 1,
                'nama_kelas' => 'Kelas 1B',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 3,
                'sekolah_id' => 3,
                'nama_kelas' => 'Kelas 10 IPA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Siswa
        DB::table('siswa')->insert([
            [
                'siswa_id' => 1,
                'kelas_id' => 1,
                'nis' => 'NIS001',
                'nama_siswa' => 'Andi Pratama',
                'jenis_kelamin' => 'L',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 2,
                'kelas_id' => 2,
                'nis' => 'NIS002',
                'nama_siswa' => 'Rina Cahya',
                'jenis_kelamin' => 'P',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 3,
                'kelas_id' => 3,
                'nis' => 'NIS003',
                'nama_siswa' => 'Dewi Lestari',
                'jenis_kelamin' => 'P',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 4,
                'kelas_id' => 3,
                'nis' => 'NIS004',
                'nama_siswa' => 'Agus Setiawan',
                'jenis_kelamin' => 'L',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Kriteria
        DB::table('kriteria')->insert([
            [
                'kriteria_id' => 1,
                'sekolah_id' => 1,
                'kode_kriteria' => 'K1',
                'nama_kriteria' => 'Nilai Rata-Rata',
                'jenis' => 'benefit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 2,
                'sekolah_id' => 1,
                'kode_kriteria' => 'K2',
                'nama_kriteria' => 'Jumlah Absen',
                'jenis' => 'cost',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 3,
                'sekolah_id' => 3,
                'kode_kriteria' => 'K3',
                'nama_kriteria' => 'Kedisiplinan',
                'jenis' => 'benefit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Bobot Kriteria
        DB::table('bobot_kriteria')->insert([
            [
                'bobot_id' => 1,
                'kriteria_id' => 1,
                'bobot' => 0.4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bobot_id' => 2,
                'kriteria_id' => 2,
                'bobot' => 0.3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bobot_id' => 3,
                'kriteria_id' => 3,
                'bobot' => 0.3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Periode
        DB::table('periode')->insert([
            [
                'periode_id' => 1,
                'tahun_ajaran' => '2024/2025',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'periode_id' => 2,
                'tahun_ajaran' => '2025/2026',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Penilaian
        DB::table('penilaian')->insert([
            [
                'penilaian_id' => 1,
                'siswa_id' => 1,
                'kelas_id' => 1,
                'kriteria_id' => 1,
                'periode_id' => 1,
                'nilai_kriteria' => 85.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'penilaian_id' => 2,
                'siswa_id' => 2,
                'kelas_id' => 2,
                'kriteria_id' => 1,
                'periode_id' => 1,
                'nilai_kriteria' => 90.25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'penilaian_id' => 3,
                'siswa_id' => 3,
                'kelas_id' => 3,
                'kriteria_id' => 3,
                'periode_id' => 2,
                'nilai_kriteria' => 88.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
