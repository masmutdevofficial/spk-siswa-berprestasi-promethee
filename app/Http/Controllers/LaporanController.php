<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
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
            ->orderByRaw('CAST(ranking AS UNSIGNED)')
            ->get();
        $tertinggi = $data->sortByDesc('net_flow')->first();
        $sekolahList = Sekolah::orderBy('nama_sekolah')->get();

        return view('laporan-admin-yayasan', compact('data', 'tertinggi', 'sekolahList'));
    }

    public function cetakAdminYayasan()
    {

        $data = Rekomendasi::with(['siswa', 'kelas', 'periode'])
            ->orderBy('periode_id')
            ->orderBy('kelas_id')
            ->orderByRaw('CAST(ranking AS UNSIGNED)')
            ->get();

        return view('cetak-laporan-yayasan', compact('data'));
    }

    public function laporanAdminSekolah()
    {
        $sekolah_id = Auth::guard('admin_sekolah')->user()->sekolah_id;

        $data = Rekomendasi::with(['siswa', 'kelas', 'periode'])
            ->whereHas('kelas', fn($q) => $q->where('sekolah_id', $sekolah_id))
            ->orderBy('periode_id')
            ->orderByRaw('CAST(ranking AS UNSIGNED)')
            ->get();

        $tertinggi = $data->sortByDesc('net_flow')->first();

        return view('laporan-admin-sekolah', compact('data', 'tertinggi'));
    }


    public function cetakAdminSekolah()
    {
        $sekolah_id = Auth::guard('admin_sekolah')->user()->sekolah_id;

        $data = Rekomendasi::with(['siswa', 'kelas', 'periode'])
            ->whereHas('kelas', fn ($q) => $q->where('sekolah_id', $sekolah_id))
            ->orderByRaw('CAST(ranking AS UNSIGNED)')
            ->get();

        return view('cetak-laporan-sekolah', compact('data'));
    }

    public function cetakPerSekolah($sekolahId)
    {
        $data = Rekomendasi::with(['siswa', 'kelas', 'periode'])
            ->whereHas('kelas', fn($q) => $q->where('sekolah_id', $sekolahId))
            ->orderByRaw('CAST(ranking AS UNSIGNED)')
            ->get();

        $tertinggi = $data->sortByDesc('net_flow')->first();
        $sekolah = Sekolah::find($sekolahId);

        return view('cetak-sekolah', compact('data', 'tertinggi', 'sekolah'));
    }
}
