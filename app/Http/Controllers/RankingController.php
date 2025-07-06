<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ranking;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Periode;
use App\Models\UserGuru;

class RankingController extends Controller
{
    public function index()
    {
        $sekolah_id = UserGuru::find(session('user_id'))->sekolah_id;

        $data = Ranking::with(['siswa', 'kelas', 'periode'])
            ->whereHas('kelas', function ($query) use ($sekolah_id) {
                $query->where('sekolah_id', $sekolah_id);
            })->get();

        $siswa = Siswa::whereHas('kelas', function ($query) use ($sekolah_id) {
            $query->where('sekolah_id', $sekolah_id);
        })->get();

        $kelas = Kelas::where('sekolah_id', $sekolah_id)->get();
        $periode = Periode::all();

        return view('data-ranking', compact('data', 'siswa', 'kelas', 'periode'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'siswa_id' => 'required',
        'kelas_id' => 'required',
        'periode_id' => 'required',
        'net_flow' => 'required',
        'ranking' => 'required',
        ]);

        $data = new Ranking();
        $data->siswa_id = $request->siswa_id;
        $data->kelas_id = $request->kelas_id;
        $data->periode_id = $request->periode_id;
        $data->net_flow = $request->net_flow;
        $data->ranking = $request->ranking;
        $data->save();

        return redirect()->back()->with('success', 'Ranking berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
        'siswa_id' => 'required',
        'kelas_id' => 'required',
        'periode_id' => 'required',
        'net_flow' => 'required',
        'ranking' => 'required',
        ]);

        $data = Ranking::findOrFail($id);
        $data->siswa_id = $request->siswa_id;
        $data->kelas_id = $request->kelas_id;
        $data->periode_id = $request->periode_id;
        $data->net_flow = $request->net_flow;
        $data->ranking = $request->ranking;
        $data->save();

        return redirect()->back()->with('success', 'Ranking berhasil diperbarui');
    }

    public function destroy($id)
    {
        $data = Ranking::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Ranking berhasil dihapus');
    }
}
