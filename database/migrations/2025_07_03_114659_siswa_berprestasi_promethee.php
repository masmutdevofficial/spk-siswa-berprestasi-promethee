<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admin_yayasan', function (Blueprint $table) {
            $table->id('admin_yayasan_id');
            $table->string('username', 50);
            $table->string('email', 50);
            $table->string('password', 255);
            $table->timestamps();
        });

        Schema::create('yayasan', function (Blueprint $table) {
            $table->id('yayasan_id');
            $table->string('nama_yayasan', 100);
            $table->string('alamat', 255);
            $table->unsignedBigInteger('admin_yayasan_id');
            $table->timestamps();

            $table->foreign('admin_yayasan_id')->references('admin_yayasan_id')->on('admin_yayasan')->onDelete('cascade');
        });

        Schema::create('sekolah', function (Blueprint $table) {
            $table->id('sekolah_id');
            $table->unsignedBigInteger('yayasan_id');
            $table->string('nama_sekolah', 100);
            $table->string('alamat', 255);
            $table->timestamps();

            $table->foreign('yayasan_id')->references('yayasan_id')->on('yayasan')->onDelete('cascade');
        });

        Schema::create('admin_sekolah', function (Blueprint $table) {
            $table->id('admin_sekolah_id');
            $table->string('username', 50);
            $table->string('email', 50);
            $table->string('password', 255);
            $table->unsignedBigInteger('sekolah_id');
            $table->timestamps();

            $table->foreign('sekolah_id')->references('sekolah_id')->on('sekolah')->onDelete('cascade');
        });

        Schema::create('user_guru', function (Blueprint $table) {
            $table->id('user_guru_id');
            $table->unsignedBigInteger('sekolah_id');
            $table->string('username', 50);
            $table->string('email', 50);
            $table->string('password', 255);
            $table->string('nama', 255);
            $table->timestamps();

            $table->foreign('sekolah_id')->references('sekolah_id')->on('sekolah')->onDelete('cascade');
        });

        Schema::create('kelas', function (Blueprint $table) {
            $table->id('kelas_id');
            $table->unsignedBigInteger('sekolah_id');
            $table->string('nama_kelas', 50);
            $table->timestamps();

            $table->foreign('sekolah_id')->references('sekolah_id')->on('sekolah')->onDelete('cascade');
        });

        Schema::create('siswa', function (Blueprint $table) {
            $table->id('siswa_id');
            $table->unsignedBigInteger('kelas_id');
            $table->string('nis', 50);
            $table->string('nama_siswa', 100);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->timestamps();

            $table->foreign('kelas_id')->references('kelas_id')->on('kelas')->onDelete('cascade');
        });

        Schema::create('kriteria', function (Blueprint $table) {
            $table->id('kriteria_id');
            $table->unsignedBigInteger('sekolah_id');
            $table->string('kode_kriteria', 50);
            $table->string('nama_kriteria', 50);
            $table->enum('jenis', ['benefit', 'cost']);
            $table->timestamps();

            $table->foreign('sekolah_id')->references('sekolah_id')->on('sekolah')->onDelete('cascade');
        });

        Schema::create('bobot_kriteria', function (Blueprint $table) {
            $table->id('bobot_id');
            $table->unsignedBigInteger('kriteria_id');
            $table->decimal('bobot', 8, 2);
            $table->timestamps();

            $table->foreign('kriteria_id')->references('kriteria_id')->on('kriteria')->onDelete('cascade');
        });

        Schema::create('periode', function (Blueprint $table) {
            $table->id('periode_id');
            $table->string('tahun_ajaran', 50);
            $table->timestamps();
        });

        Schema::create('penilaian', function (Blueprint $table) {
            $table->id('penilaian_id');
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('kriteria_id');
            $table->unsignedBigInteger('periode_id');
            $table->decimal('nilai_kriteria', 5, 2);
            $table->timestamps();

            $table->foreign('siswa_id')->references('siswa_id')->on('siswa')->onDelete('cascade');
            $table->foreign('kelas_id')->references('kelas_id')->on('kelas')->onDelete('cascade');
            $table->foreign('kriteria_id')->references('kriteria_id')->on('kriteria')->onDelete('cascade');
            $table->foreign('periode_id')->references('periode_id')->on('periode')->onDelete('cascade');
        });

        Schema::create('ranking', function (Blueprint $table) {
            $table->id('ranking_id');
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('periode_id');
            $table->decimal('net_flow', 5, 2);
            $table->string('ranking', 255);
            $table->timestamps();

            $table->foreign('siswa_id')->references('siswa_id')->on('siswa')->onDelete('cascade');
            $table->foreign('kelas_id')->references('kelas_id')->on('kelas')->onDelete('cascade');
            $table->foreign('periode_id')->references('periode_id')->on('periode')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ranking');
        Schema::dropIfExists('penilaian');
        Schema::dropIfExists('periode');
        Schema::dropIfExists('bobot_kriteria');
        Schema::dropIfExists('kriteria');
        Schema::dropIfExists('siswa');
        Schema::dropIfExists('kelas');
        Schema::dropIfExists('user_guru');
        Schema::dropIfExists('admin_sekolah');
        Schema::dropIfExists('sekolah');
        Schema::dropIfExists('yayasan');
        Schema::dropIfExists('admin_yayasan');
    }
};
