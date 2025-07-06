<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Kriteria;
use App\Models\Periode;
use App\Models\Semester;
use App\Models\UserGuru;

class PenilaianController extends Controller
{
    public function index()
    {
        $user = UserGuru::find(session('user_id'));
        $sekolah_id = $user->sekolah_id;

        $data = Penilaian::with(['siswa', 'kelas', 'kriteria', 'periode', 'semester'])
            ->whereHas('kelas', function ($query) use ($sekolah_id) {
                $query->where('sekolah_id', $sekolah_id);
            })->get();

        $siswa = Siswa::whereHas('kelas', function ($query) use ($sekolah_id) {
            $query->where('sekolah_id', $sekolah_id);
        })->with('kelas')->get();

        $kelas = Kelas::where('sekolah_id', $sekolah_id)->get();
        $kriteria = Kriteria::where('sekolah_id', $sekolah_id)->get();
        $periode = Periode::all();

        $semuaSemester = Semester::orderBy('semester_id')->get();

        $semesterTersedia = [];

        foreach ($siswa as $s) {
            $nama_kelas = preg_replace('/[^0-9]/', '', $s->kelas->nama_kelas);
            $nama_kelas = (int) $nama_kelas;

            $maks_semester = 12;
            if (in_array($nama_kelas, [7, 8, 9, 10, 11, 12])) {
                $maks_semester = 6;
            }

            $sudahIsi = Penilaian::where('siswa_id', $s->siswa_id)
                ->orderBy('semester_id', 'asc')
                ->pluck('semester_id')
                ->toArray();

            if (empty($sudahIsi)) {
                $nextSemester = 1;
            } else {
                $nextSemester = max($sudahIsi) + 1;
            }

            $semesterTersedia[$s->siswa_id] = $semuaSemester
                ->where('semester_id', '>=', $nextSemester)
                ->where('semester_id', '<=', $maks_semester)
                ->values();
        }

        return view('data-penilaian', compact(
            'data', 'siswa', 'kelas', 'kriteria', 'periode',
            'semesterTersedia'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'kelas_id' => 'required',
            'kriteria_id' => 'required',
            'semester_id' => 'required',
            'periode_id' => 'required',
            'nilai_kriteria' => 'required',
        ]);

        $existing = Penilaian::where('siswa_id', $request->siswa_id)
        ->where('semester_id', $request->semester_id)
        ->where('kriteria_id', $request->kriteria_id)
        ->first();

        if ($existing) {
            return redirect()->back()->withErrors([
                'Kriteria ini sudah diinput untuk semester tersebut.'
            ]);
        }

        // Cek apakah kriteria ini sudah pernah diinput untuk semester tsb
        $duplikat = Penilaian::where('siswa_id', $request->siswa_id)
            ->where('semester_id', $request->semester_id)
            ->where('kriteria_id', $request->kriteria_id)
            ->first();

        if ($duplikat) {
            return redirect()->back()->withErrors([
                'Kriteria ini sudah pernah diinput untuk semester tersebut.'
            ]);
        }

        // Cek semester terakhir yang pernah diinput oleh siswa
        $semesterTerakhir = Penilaian::where('siswa_id', $request->siswa_id)
            ->orderBy('semester_id', 'desc')
            ->pluck('semester_id')
            ->first();

        // Jika belum pernah isi → harus mulai dari semester 1
        if (!$semesterTerakhir && $request->semester_id != 1) {
            return redirect()->back()->withErrors([
                'Penilaian harus dimulai dari Semester 1.'
            ]);
        }

        // Ambil semua kriteria_id yang sudah diisi di semester sekarang
        $kriteriaTerisi = Penilaian::where('siswa_id', $request->siswa_id)
            ->where('semester_id', $request->semester_id)
            ->pluck('kriteria_id')
            ->toArray();

        // Ambil semua kriteria_id yang seharusnya masuk untuk semester tersebut
        $kodeSemester = 'Semester ' . $request->semester_id;
        $kriteriaSesuai = Kriteria::where('nama_kriteria', 'like', "%$kodeSemester%")
            ->orWhere('nama_kriteria', 'like', '%Prestasi%') // Prestasi boleh kapan saja
            ->pluck('kriteria_id')
            ->toArray();

        // Jika kriteria yang dimasukkan tidak termasuk dalam yang diizinkan
        if (!in_array($request->kriteria_id, $kriteriaSesuai)) {
            return redirect()->back()->withErrors([
                'Kriteria tidak sesuai dengan semester yang dipilih.'
            ]);
        }

        // Jika semester sebelumnya belum lengkap tapi sudah lanjut ke semester selanjutnya
        if ($semesterTerakhir && $request->semester_id > $semesterTerakhir) {
            $jumlahSebelum = Penilaian::where('siswa_id', $request->siswa_id)
                ->where('semester_id', $semesterTerakhir)
                ->count();

            // misalnya kamu ekspektasi 3 kriteria per semester
            if ($jumlahSebelum < 3) {
                return redirect()->back()->withErrors([
                    'Semester sebelumnya belum lengkap, harap selesaikan terlebih dahulu.'
                ]);
            }
        }

        $data = new Penilaian();
        $data->siswa_id = $request->siswa_id;
        $data->kelas_id = $request->kelas_id;
        $data->kriteria_id = $request->kriteria_id;
        $data->semester_id = $request->semester_id;
        $data->periode_id = $request->periode_id;
        $data->nilai_kriteria = $request->nilai_kriteria;
        $data->save();

        return redirect()->back()->with('success', 'Penilaian berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
        'siswa_id' => 'required',
        'kelas_id' => 'required',
        'kriteria_id' => 'required',
        'semester_id' => 'required',
        'periode_id' => 'required',
        'nilai_kriteria' => 'required',
        ]);

        $data = Penilaian::findOrFail($id);
        $data->siswa_id = $request->siswa_id;
        $data->kelas_id = $request->kelas_id;
        $data->kriteria_id = $request->kriteria_id;
        $data->semester_id = $request->semester_id;
        $data->periode_id = $request->periode_id;
        $data->nilai_kriteria = $request->nilai_kriteria;
        $data->save();

        return redirect()->back()->with('success', 'Penilaian berhasil diperbarui');
    }

    public function destroy($id)
    {
        $data = Penilaian::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Penilaian berhasil dihapus');
    }
}
