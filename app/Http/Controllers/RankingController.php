<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ranking;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Periode;

class RankingController extends Controller
{
    public function index()
    {
        $data = Ranking::with(['siswa', 'kelas', 'periode'])->get();
        $siswa = Siswa::all();
        $kelas = Kelas::all();
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
