<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\UserGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserGuruController extends Controller
{
    public function index()
    {
        // Ambil sekolah_id dari admin_sekolah yang sedang login
        $sekolah_id = Auth::guard('admin_sekolah')->user()->sekolah_id;

        // Ambil data guru sesuai sekolah
        $data = UserGuru::with('sekolah')
            ->where('sekolah_id', $sekolah_id)
            ->get();

        // Ambil hanya 1 sekolah (sekolah yang login)
        $sekolah = Sekolah::where('sekolah_id', $sekolah_id)->get();

        return view('data-guru', compact('data', 'sekolah'));
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
