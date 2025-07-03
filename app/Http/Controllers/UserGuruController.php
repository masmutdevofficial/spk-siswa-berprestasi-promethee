<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserGuru;

class UserGuruController extends Controller
{
    public function index()
    {
        $data = UserGuru::all();
        return view('data-guru', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'sekolah_id' => 'required',
        'username' => 'required',
        'email' => 'required',
        'password' => 'required',
        'nama' => 'required',
        ]);

        $data = new UserGuru();
        $data->sekolah_id = $request->sekolah_id;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->password = $request->password;
        $data->nama = $request->nama;
        $data->save();

        return redirect()->back()->with('success', 'UserGuru berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
        'sekolah_id' => 'required',
        'username' => 'required',
        'email' => 'required',
        'password' => 'required',
        'nama' => 'required',
        ]);

        $data = UserGuru::findOrFail($id);
        $data->sekolah_id = $request->sekolah_id;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->password = $request->password;
        $data->nama = $request->nama;
        $data->save();

        return redirect()->back()->with('success', 'UserGuru berhasil diperbarui');
    }

    public function destroy($id)
    {
        $data = UserGuru::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'UserGuru berhasil dihapus');
    }
}
