<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;

class KriteriaController extends Controller
{
    public function index()
    {
        $data = Kriteria::all();
        return view('kriteria.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'sekolah_id' => 'required',
        'kode_kriteria' => 'required',
        'nama_kriteria' => 'required',
        'jenis' => 'required',
        ]);

        $data = new Kriteria();
        $data->sekolah_id = $request->sekolah_id;
        $data->kode_kriteria = $request->kode_kriteria;
        $data->nama_kriteria = $request->nama_kriteria;
        $data->jenis = $request->jenis;
        $data->save();

        return redirect()->back()->with('success', 'Kriteria berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
        'sekolah_id' => 'required',
        'kode_kriteria' => 'required',
        'nama_kriteria' => 'required',
        'jenis' => 'required',
        ]);

        $data = Kriteria::findOrFail($id);
        $data->sekolah_id = $request->sekolah_id;
        $data->kode_kriteria = $request->kode_kriteria;
        $data->nama_kriteria = $request->nama_kriteria;
        $data->jenis = $request->jenis;
        $data->save();

        return redirect()->back()->with('success', 'Kriteria berhasil diperbarui');
    }

    public function destroy($id)
    {
        $data = Kriteria::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Kriteria berhasil dihapus');
    }
}
