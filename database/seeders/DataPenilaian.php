<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Traits\ImportPenilaianTrait;
use App\Models\NilaiPrestasi;

class DataPenilaian extends Seeder
{
    use ImportPenilaianTrait;

    public function run(): void
    {
        // Data penilaian dari file Excel
        $this->importPenilaian(storage_path('app/seeders/penilaian-sd.xlsx'), kelasId: 1, periodeId: 1);
        $this->importPenilaian(storage_path('app/seeders/penilaian-smp.xlsx'), kelasId: 2, periodeId: 1);
        $this->importPenilaian(storage_path('app/seeders/penilaian-sma.xlsx'), kelasId: 3, periodeId: 1);

        // Nilai Prestasi Manual
        foreach (range(1, 96) as $siswaId) {
            if ($siswaId <= 36) {
                $kriteriaId = 37;
            } elseif ($siswaId <= 66) {
                $kriteriaId = 56;
            } else {
                $kriteriaId = 75;
            }

            NilaiPrestasi::create([
                'siswa_id'       => $siswaId,
                'kriteria_id'    => $kriteriaId,
                'periode_id'     => 1,
                'nilai_kriteria' => 0,
            ]);
        }
    }

}
