<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminYayasan;

class AdminYayasanController extends Controller
{
    public function index()
    {
        $data = AdminYayasan::all();
        return view('data-admin-yayasan', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'username' => 'required',
        'email' => 'required',
        'password' => 'required',
        ]);

        $data = new AdminYayasan();
        $data->username = $request->username;
        $data->email = $request->email;
        $data->password = $request->password;
        $data->save();

        return redirect()->back()->with('success', 'AdminYayasan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
        'username' => 'required',
        'email' => 'required',
        'password' => 'required',
        ]);

        $data = AdminYayasan::findOrFail($id);
        $data->username = $request->username;
        $data->email = $request->email;
        $data->password = $request->password;
        $data->save();

        return redirect()->back()->with('success', 'AdminYayasan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $data = AdminYayasan::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'AdminYayasan berhasil dihapus');
    }
}
