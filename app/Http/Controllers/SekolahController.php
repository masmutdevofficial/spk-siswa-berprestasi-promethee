<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sekolah;
use App\Models\Yayasan;

class SekolahController extends Controller
{
    public function index()
    {
        $data = Sekolah::with('yayasan')->get();
        $yayasan = Yayasan::all();

        return view('data-sekolah', compact('data', 'yayasan'));
    }
    public function store(Request $request)
    {
        $request->validate([
        'yayasan_id' => 'required',
        'nama_sekolah' => 'required',
        'alamat' => 'required',
        ]);

        $data = new Sekolah();
        $data->yayasan_id = $request->yayasan_id;
        $data->nama_sekolah = $request->nama_sekolah;
        $data->alamat = $request->alamat;
        $data->save();

        return redirect()->back()->with('success', 'Sekolah berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
        'yayasan_id' => 'required',
        'nama_sekolah' => 'required',
        'alamat' => 'required',
        ]);

        $data = Sekolah::findOrFail($id);
        $data->yayasan_id = $request->yayasan_id;
        $data->nama_sekolah = $request->nama_sekolah;
        $data->alamat = $request->alamat;
        $data->save();

        return redirect()->back()->with('success', 'Sekolah berhasil diperbarui');
    }

    public function destroy($id)
    {
        $data = Sekolah::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Sekolah berhasil dihapus');
    }
}
