<?php

namespace Database\Seeders\Traits;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Kriteria;
use App\Models\Penilaian;

trait ImportPenilaianTrait
{
    /**
     * @param string $path      path ke file excel
     * @param int    $kelasId
     * @param int    $periodeId
     */
    public function importPenilaian(string $path, int $kelasId, int $periodeId): void
    {
        $sheet = Excel::toCollection(null, $path)->first();
        if (!$sheet || $sheet->isEmpty()) {
            $this->command->warn("Sheet {$path} kosong / tidak terbaca.");
            return;
        }

        $siswaIds = $sheet[0]->slice(1)->values(); // header kolom B..AK

        DB::transaction(function () use ($sheet, $siswaIds, $kelasId, $periodeId) {
            foreach ($sheet->slice(1) as $row) {
                $kriteriaId = $row[0];
                if (!$kriteriaId) continue;

                $kriteria = Kriteria::find($kriteriaId);
                if (!$kriteria) continue;

                if (!preg_match('/Semester\s+(\d+)/i', $kriteria->nama_kriteria, $m)) {
                    // "Prestasi" → skip
                    continue;
                }
                $semesterId = (int)$m[1];

                foreach ($siswaIds as $colIdx => $siswaId) {
                    $nilai = $row[$colIdx + 1];
                    if ($nilai === null || $nilai === '') continue;

                    Penilaian::create([
                        'siswa_id'       => $siswaId,
                        'kelas_id'       => $kelasId,
                        'kriteria_id'    => $kriteriaId,
                        'periode_id'     => $periodeId,
                        'semester_id'    => $semesterId,
                        'nilai_kriteria' => $nilai,
                    ]);
                }
            }
        });
    }
}
