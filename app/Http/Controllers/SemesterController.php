<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Semester;

class SemesterController extends Controller
{
    public function index()
    {
        $data = Semester::all();
        return view('data-semester', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'nama' => 'required',
        ]);

        $data = new Semester();
        $data->nama = $request->nama;
        $data->save();

        return redirect()->back()->with('success', 'Semester berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
        'nama' => 'required',
        ]);

        $data = Semester::findOrFail($id);
        $data->nama = $request->nama;
        $data->save();

        return redirect()->back()->with('success', 'Semester berhasil diperbarui');
    }

    public function destroy($id)
    {
        $data = Semester::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Semester berhasil dihapus');
    }
}
