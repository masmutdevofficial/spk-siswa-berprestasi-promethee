<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BobotKriteria;

class BobotKriteriaController extends Controller
{
    public function index()
    {
        $data = BobotKriteria::all();
        return view('bobotkriteria.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'kriteria_id' => 'required',
        'bobot' => 'required',
        ]);

        $data = new BobotKriteria();
        $data->kriteria_id = $request->kriteria_id;
        $data->bobot = $request->bobot;
        $data->save();

        return redirect()->back()->with('success', 'BobotKriteria berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
        'kriteria_id' => 'required',
        'bobot' => 'required',
        ]);

        $data = BobotKriteria::findOrFail($id);
        $data->kriteria_id = $request->kriteria_id;
        $data->bobot = $request->bobot;
        $data->save();

        return redirect()->back()->with('success', 'BobotKriteria berhasil diperbarui');
    }

    public function destroy($id)
    {
        $data = BobotKriteria::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'BobotKriteria berhasil dihapus');
    }
}
