<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;

class PenilaianController extends Controller
{
    public function index()
    {
        $data = Penilaian::all();
        return view('penilaian.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'siswa_id' => 'required',
        'kelas_id' => 'required',
        'kriteria_id' => 'required',
        'periode_id' => 'required',
        'nilai_kriteria' => 'required',
        ]);

        $data = new Penilaian();
        $data->siswa_id = $request->siswa_id;
        $data->kelas_id = $request->kelas_id;
        $data->kriteria_id = $request->kriteria_id;
        $data->periode_id = $request->periode_id;
        $data->nilai_kriteria = $request->nilai_kriteria;
        $data->save();

        return redirect()->back()->with('success', 'Penilaian berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
        'siswa_id' => 'required',
        'kelas_id' => 'required',
        'kriteria_id' => 'required',
        'periode_id' => 'required',
        'nilai_kriteria' => 'required',
        ]);

        $data = Penilaian::findOrFail($id);
        $data->siswa_id = $request->siswa_id;
        $data->kelas_id = $request->kelas_id;
        $data->kriteria_id = $request->kriteria_id;
        $data->periode_id = $request->periode_id;
        $data->nilai_kriteria = $request->nilai_kriteria;
        $data->save();

        return redirect()->back()->with('success', 'Penilaian berhasil diperbarui');
    }

    public function destroy($id)
    {
        $data = Penilaian::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Penilaian berhasil dihapus');
    }
}
