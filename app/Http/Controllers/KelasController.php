<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{

    public function index()
    {
        // Ambil sekolah_id dari admin_sekolah yang login
        $sekolah_id = Auth::guard('admin_sekolah')->user()->sekolah_id;

        // Ambil data kelas hanya milik sekolah ini
        $data = Kelas::with('sekolah')
            ->where('sekolah_id', $sekolah_id)
            ->get();

        // Ambil info sekolahnya
        $sekolah = Sekolah::where('sekolah_id', $sekolah_id)->get();

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
