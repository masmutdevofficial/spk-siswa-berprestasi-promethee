<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Periode;
use App\Models\Kriteria;
use App\Models\Semester;
use App\Models\UserGuru;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use App\Models\NilaiPrestasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    public function index()
    {
        // 1. Ambil sekolah_id dari guru yang sedang login
        $sekolah_id = Auth::guard('user_guru')->user()->sekolah_id;

        // 2. Ambil data siswa (dengan kelas)
        $siswa = Siswa::select('siswa_id', 'kelas_id', 'nis', 'nama_siswa', 'jenis_kelamin')
            ->whereHas('kelas', fn ($q) => $q->where('sekolah_id', $sekolah_id))
            ->with(['kelas:kelas_id,sekolah_id,nama_kelas'])
            ->get();

        // 3. Ambil data kelas dari sekolah tersebut
        $kelas = Kelas::select('kelas_id', 'nama_kelas')
            ->where('sekolah_id', $sekolah_id)
            ->get();

        // 4. Ambil kriteria dari sekolah tersebut
        $kriteria = Kriteria::select('kriteria_id', 'kode_kriteria', 'nama_kriteria')
            ->where('sekolah_id', $sekolah_id)
            ->get();

        // 5. Ambil semua periode
        $periode = Periode::select('periode_id', 'tahun_ajaran')->get();

        // 6. Ambil semua semester
        $semuaSemester = Semester::orderBy('semester_id')->get(['semester_id', 'nama']);

        // 7. Ambil data penilaian (maksimal 1000 untuk jaga performa)
        $data = Penilaian::with(['siswa', 'kelas', 'kriteria', 'periode', 'semester'])
            ->whereHas('kelas', fn ($q) => $q->where('sekolah_id', $sekolah_id))
            ->orderByDesc('penilaian_id')
            ->get();

        // 8. Ambil data nilai prestasi siswa berdasarkan sekolah
        $nilaiPrestasi = NilaiPrestasi::with(['siswa.kelas', 'kriteria', 'periode'])
            ->whereHas('siswa.kelas', fn ($q) => $q->where('sekolah_id', $sekolah_id))
            ->get();

        $kriteriaPrestasi = Kriteria::where('sekolah_id', $sekolah_id)
            ->where('nama_kriteria', 'Prestasi')
            ->select('kriteria_id', 'nama_kriteria')
            ->get();

        $nilaiPrestasiTersimpan = NilaiPrestasi::select('siswa_id', 'kriteria_id', 'periode_id', 'nilai_kriteria')
            ->whereIn('siswa_id', $siswa->pluck('siswa_id'))
            ->get()
            ->mapWithKeys(function ($item) {
                return [ $item->siswa_id . '-' . $item->kriteria_id . '-' . $item->periode_id => $item->nilai_kriteria ];
            });

        // 9. Kirim ke view
        return view('data-penilaian', [
            'data'           => $data,
            'siswa'          => $siswa,
            'kelas'          => $kelas,
            'kriteria'       => $kriteria,
            'periode'        => $periode,
            'semuaSemester'  => $semuaSemester,
            'nilaiPrestasi'  => $nilaiPrestasi,
            'nilaiPrestasiTersimpan' => $nilaiPrestasiTersimpan,
            'kriteriaPrestasi' => $kriteriaPrestasi
        ]);
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

    public function ajaxEdit($id): JsonResponse
    {
        $penilaian = Penilaian::with(['siswa', 'kelas', 'kriteria', 'periode', 'semester'])
            ->findOrFail($id);

        $sekolah_id = Auth::guard('user_guru')->user()->sekolah_id;

        $siswa   = Siswa::whereHas('kelas', fn ($q) => $q->where('sekolah_id', $sekolah_id))
                        ->select('siswa_id', 'nama_siswa')
                        ->get();

        $kelas   = Kelas::where('sekolah_id', $sekolah_id)
                        ->select('kelas_id', 'nama_kelas')
                        ->get();

        $kriteria = Kriteria::where('sekolah_id', $sekolah_id)
                            ->select('kriteria_id', 'nama_kriteria')
                            ->get();

        $periode  = Periode::select('periode_id', 'tahun_ajaran')->get();
        $semuaSemester = Semester::select('semester_id', 'nama')->orderBy('semester_id')->get();

        $form = view('partials.edit-penilaian',
            compact('penilaian', 'siswa', 'kelas', 'kriteria', 'periode', 'semuaSemester')
        )->render();

        return response()->json(['form' => $form]);
    }

    public function ajaxHapus($id): JsonResponse
    {
        $penilaian = Penilaian::find($id);

        if (!$penilaian) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $penilaian->delete();

        return response()->json([
            'status' => true,
            'message' => 'Penilaian berhasil dihapus.'
        ]);
    }

    public function prestasi(Request $request)
    {
        $request->validate([
            'siswa_id'        => 'required|exists:siswa,siswa_id',
            'kriteria_id'     => 'required|exists:kriteria,kriteria_id',
            'periode_id'      => 'required|exists:periode,periode_id',
            'nilai_kriteria'  => 'required|numeric|min:0',
        ]);

        $data = NilaiPrestasi::updateOrCreate(
            [
                'siswa_id'    => $request->siswa_id,
                'kriteria_id' => $request->kriteria_id,
                'periode_id'  => $request->periode_id
            ],
            [
                'nilai_kriteria' => $request->nilai_kriteria
            ]
        );

        return redirect()->back()->with('success', 'Nilai prestasi berhasil disimpan.');
    }
}
