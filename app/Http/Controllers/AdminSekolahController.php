<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminSekolah;

class AdminSekolahController extends Controller
{
    public function index()
    {
        $data = AdminSekolah::all();
        return view('data-admin-sekolah', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'username' => 'required',
        'email' => 'required',
        'password' => 'required',
        'sekolah_id' => 'required',
        ]);

        $data = new AdminSekolah();
        $data->username = $request->username;
        $data->email = $request->email;
        $data->password = $request->password;
        $data->sekolah_id = $request->sekolah_id;
        $data->save();

        return redirect()->back()->with('success', 'AdminSekolah berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
        'username' => 'required',
        'email' => 'required',
        'password' => 'required',
        'sekolah_id' => 'required',
        ]);

        $data = AdminSekolah::findOrFail($id);
        $data->username = $request->username;
        $data->email = $request->email;
        $data->password = $request->password;
        $data->sekolah_id = $request->sekolah_id;
        $data->save();

        return redirect()->back()->with('success', 'AdminSekolah berhasil diperbarui');
    }

    public function destroy($id)
    {
        $data = AdminSekolah::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'AdminSekolah berhasil dihapus');
    }
}
