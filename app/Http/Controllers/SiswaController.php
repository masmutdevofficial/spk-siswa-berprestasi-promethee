<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\UserGuru;

class SiswaController extends Controller
{
    public function index()
    {
        $sekolah_id = UserGuru::find(session('user_id'))->sekolah_id;

        $data = Siswa::with('kelas.sekolah')
            ->whereHas('kelas', function ($query) use ($sekolah_id) {
                $query->where('sekolah_id', $sekolah_id);
            })
            ->get();

        $kelas = Kelas::where('sekolah_id', $sekolah_id)->get();

        return view('data-siswa', [
            'data' => $data,
            'kelas' => $kelas
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
        'kelas_id' => 'required',
        'nis' => 'required',
        'nama_siswa' => 'required',
        'jenis_kelamin' => 'required',
        ]);

        $data = new Siswa();
        $data->kelas_id = $request->kelas_id;
        $data->nis = $request->nis;
        $data->nama_siswa = $request->nama_siswa;
        $data->jenis_kelamin = $request->jenis_kelamin;
        $data->save();

        return redirect()->back()->with('success', 'Siswa berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
        'kelas_id' => 'required',
        'nis' => 'required',
        'nama_siswa' => 'required',
        'jenis_kelamin' => 'required',
        ]);

        $data = Siswa::findOrFail($id);
        $data->kelas_id = $request->kelas_id;
        $data->nis = $request->nis;
        $data->nama_siswa = $request->nama_siswa;
        $data->jenis_kelamin = $request->jenis_kelamin;
        $data->save();

        return redirect()->back()->with('success', 'Siswa berhasil diperbarui');
    }

    public function destroy($id)
    {
        $data = Siswa::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Siswa berhasil dihapus');
    }
}
