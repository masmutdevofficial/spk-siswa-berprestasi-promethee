<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periode;

class PeriodeController extends Controller
{
    public function index()
    {
        $data = Periode::all();
        return view('data-periode', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'tahun_ajaran' => 'required',
        ]);

        $data = new Periode();
        $data->tahun_ajaran = $request->tahun_ajaran;
        $data->save();

        return redirect()->back()->with('success', 'Periode berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
        'tahun_ajaran' => 'required',
        ]);

        $data = Periode::findOrFail($id);
        $data->tahun_ajaran = $request->tahun_ajaran;
        $data->save();

        return redirect()->back()->with('success', 'Periode berhasil diperbarui');
    }

    public function destroy($id)
    {
        $data = Periode::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Periode berhasil dihapus');
    }
}
