<?php

namespace App\Http\Controllers;

use App\Models\Rekomendasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function laporanAdminYayasan()
    {

        $data = Rekomendasi::with(['siswa', 'kelas', 'periode'])
            ->orderBy('periode_id')
            ->orderBy('kelas_id')
            ->orderBy('ranking')
            ->get();

        return view('laporan-admin-yayasan', compact('data'));
    }

    public function cetakAdminYayasan()
    {

        $data = Rekomendasi::with(['siswa', 'kelas', 'periode'])
            ->orderBy('periode_id')
            ->orderBy('kelas_id')
            ->orderBy('ranking')
            ->get();

        return view('cetak-laporan-yayasan', compact('data'));
    }

    public function laporanAdminSekolah()
    {
        $sekolah_id = Auth::guard('admin_sekolah')->user()->sekolah_id;

        $data = Rekomendasi::with(['siswa', 'kelas', 'periode'])
            ->whereHas('kelas', fn($q) => $q->where('sekolah_id', $sekolah_id))
            ->orderBy('periode_id')
            ->orderBy('ranking')
            ->get();

        return view('laporan-admin-sekolah', compact('data'));
    }


    public function cetakAdminSekolah()
    {
        $sekolah_id = Auth::guard('user_guru')->user()->sekolah_id;

        $data = Rekomendasi::with(['siswa', 'kelas', 'periode'])
            ->whereHas('kelas', fn ($q) => $q->where('sekolah_id', $sekolah_id))
            ->orderBy('ranking')
            ->get();

        return view('cetak-laporan-sekolah', compact('data'));
    }
}
