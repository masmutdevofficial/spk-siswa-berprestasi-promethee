<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\PrometheeService;
use App\Models\Rekomendasi;

class PrometheeController extends Controller
{
    /**
     * Hitung PROMETHEE, simpan/update tabel rekomendasi, lalu tampilkan detail.
     *
     * @param  int  $kelasId
     * @return \Illuminate\View\View
     */
    public function run(int $kelasId)
    {
        $periodeId = 1;                                   // ganti jika perlu
        $detail    = (new PrometheeService)->hitungDetailed($kelasId, $periodeId);

        // simpan atau update rekomendasi
        DB::transaction(function () use ($detail, $kelasId, $periodeId) {
            foreach ($detail['ranking'] as $idx => $row) {
                Rekomendasi::updateOrCreate(
                    [
                        'siswa_id'   => $row['siswa_id'],
                        'kelas_id'   => $kelasId,
                        'periode_id' => $periodeId,
                    ],
                    [
                        'net_flow' => $row['net'],
                        'ranking'  => $idx + 1,
                    ]
                );
            }
        });

        // label kelas untuk tampilan
        $kelasLabel = match ($kelasId) {
            1       => 'SD - 6A',
            2       => 'SMP - 9D',
            3       => 'SMA - 12 IPA',
            default => 'Kelas Tidak Dikenal',
        };

        return view('algoritma', compact('kelasId', 'kelasLabel', 'detail'));
    }
}
