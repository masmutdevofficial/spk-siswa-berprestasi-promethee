<?php

namespace App\Http\Controllers;

use App\Models\AdminYayasan;
use Illuminate\Http\Request;
use App\Models\Yayasan;

class YayasanController extends Controller
{
    public function index()
    {
        $data = Yayasan::with('adminyayasan')->get();
        $admin = AdminYayasan::all();

        return view('data-yayasan', compact('data', 'admin'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'nama_yayasan' => 'required',
        'alamat' => 'required',
        'admin_yayasan_id' => 'required',
        ]);

        $data = new Yayasan();
        $data->nama_yayasan = $request->nama_yayasan;
        $data->alamat = $request->alamat;
        $data->admin_yayasan_id = $request->admin_yayasan_id;
        $data->save();

        return redirect()->back()->with('success', 'Yayasan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
        'nama_yayasan' => 'required',
        'alamat' => 'required',
        'admin_yayasan_id' => 'required',
        ]);

        $data = Yayasan::findOrFail($id);
        $data->nama_yayasan = $request->nama_yayasan;
        $data->alamat = $request->alamat;
        $data->admin_yayasan_id = $request->admin_yayasan_id;
        $data->save();

        return redirect()->back()->with('success', 'Yayasan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $data = Yayasan::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Yayasan berhasil dihapus');
    }
}
