<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Sekolah;

class KelasController extends Controller
{
    public function index()
    {
        $data = Kelas::with('sekolah')->get();
        $sekolah = Sekolah::all();

        return view('data-kelas', compact('data', 'sekolah'));
    }
    public function store(Request $request)
    {
        $request->validate([
        'sekolah_id' => 'required',
        'nama_kelas' => 'required',
        ]);

        $data = new Kelas();
        $data->sekolah_id = $request->sekolah_id;
        $data->nama_kelas = $request->nama_kelas;
        $data->save();

        return redirect()->back()->with('success', 'Kelas berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
        'sekolah_id' => 'required',
        'nama_kelas' => 'required',
        ]);

        $data = Kelas::findOrFail($id);
        $data->sekolah_id = $request->sekolah_id;
        $data->nama_kelas = $request->nama_kelas;
        $data->save();

        return redirect()->back()->with('success', 'Kelas berhasil diperbarui');
    }

    public function destroy($id)
    {
        $data = Kelas::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Kelas berhasil dihapus');
    }
}
