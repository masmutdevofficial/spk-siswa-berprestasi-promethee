<?php

namespace App\Services;

use App\Models\Siswa;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\NilaiPrestasi;

class PrometheeService
{
    /**
     * Fungsi preferensi linear: nilai antara 0 dan 1 berdasarkan selisih.
     */
    private function preferenceFunction(float $na, float $nb, string $jenis = 'benefit'): float
    {
        if ($jenis === 'cost') {
            return $na <= $nb ? 1 : 0;
        }

        // default: benefit
        return $na > $nb ? 1 : 0;
    }
    /**
     * Hitung PROMETHEE detail untuk satu kelas & periode.
     */
    public function hitungDetailed(int $kelasId, int $periodeId): array
    {
        $prestasiMap       = [1 => 37, 2 => 56, 3 => 75];
        $kriteriaPrestasi  = $prestasiMap[$kelasId] ?? null;

        $siswaColl  = Siswa::where('kelas_id', $kelasId)
                        ->orderBy('siswa_id')
                        ->get(['siswa_id', 'nama_siswa']);

        $siswaIds   = $siswaColl->pluck('siswa_id')->toArray();
        $siswaNames = $siswaColl->pluck('nama_siswa', 'siswa_id')->toArray();

        $kriteria   = Kriteria::where('sekolah_id', $kelasId)
                        ->with('bobot')
                        ->orderBy('kriteria_id')
                        ->get(['kriteria_id', 'kode_kriteria', 'nama_kriteria', 'sekolah_id', 'jenis']);

        if ($kriteriaPrestasi && !$kriteria->contains('kriteria_id', $kriteriaPrestasi)) {
            $kp = Kriteria::with('bobot')->find($kriteriaPrestasi);
            if ($kp) $kriteria->push($kp);
        }

        $kriteriaIds = $kriteria->pluck('kriteria_id')->toArray();

        $kriteriaMeta = [];
        $bobot        = [];
        foreach ($kriteria as $k) {
            $kriteriaMeta[$k->kriteria_id] = [
                'kode'  => $k->kode_kriteria,
                'nama'  => $k->nama_kriteria,
                'jenis' => $k->jenis ?? 'benefit', // default 'benefit' jika null
            ];
            $bobot[$k->kriteria_id] = $k->bobot->bobot ?? 0;
        }

        $matrix = array_fill_keys($siswaIds, []);

        $pen = Penilaian::where('kelas_id', $kelasId)
                ->where('periode_id', $periodeId)
                ->whereIn('kriteria_id', $kriteriaIds)
                ->get();

        foreach ($pen as $p) {
            $matrix[$p->siswa_id][$p->kriteria_id] = $p->nilai_kriteria;
        }

        if ($kriteriaPrestasi) {
            $pres = NilaiPrestasi::where('periode_id', $periodeId)
                    ->where('kriteria_id', $kriteriaPrestasi)
                    ->get();

            foreach ($pres as $n) {
                $matrix[$n->siswa_id][$n->kriteria_id] = $n->nilai_kriteria;
            }
        }

        $pref   = [];
        $leave  = [];
        $enter  = [];
        $nAlt   = count($siswaIds) - 1;
        $perhitunganDetail = [];

        foreach ($siswaIds as $a) {
            $pref[$a] = [];
            foreach ($siswaIds as $b) {
                if ($a === $b) {
                    $pref[$a][$b] = 0;
                    continue;
                }

                $pi = 0;
                $detailStep = [];
                foreach ($kriteriaIds as $kid) {
                    $na = $matrix[$a][$kid] ?? 0;
                    $nb = $matrix[$b][$kid] ?? 0;
                    $d = $na - $nb;

                    $jenis = $kriteriaMeta[$kid]['jenis'] ?? 'benefit';
                    $prefValue = $this->preferenceFunction($na, $nb, $jenis);
                    $bobotKriteria = $bobot[$kid];
                    $kontribusi = $bobotKriteria * $prefValue;
                    $pi += $kontribusi;

                    $kode = $kriteriaMeta[$kid]['kode'] ?? "K$kid";
                    $detailStep[] = sprintf("[%s](%0.4f×%s)", $kode, $bobotKriteria, number_format($prefValue, 0));
                }

                $stepString = sprintf("(%s) = %0.4f", implode('+', $detailStep), $pi);
                $perhitunganDetail["{$a}_{$b}"] = $stepString;


                $pref[$a][$b] = round($pi, 5);
            }
        }

        foreach ($siswaIds as $a) {
            $phiPlus = $phiMinus = 0;
            foreach ($siswaIds as $b) {
                if ($a === $b) continue;
                $phiPlus  += $pref[$a][$b];
                $phiMinus += $pref[$b][$a];
            }
            $leave[$a] = $nAlt ? round($phiPlus / $nAlt, 5) : 0;
            $enter[$a] = $nAlt ? round($phiMinus / $nAlt, 5) : 0;
        }

        $net = [];
        foreach ($siswaIds as $a) {
            $net[$a] = round($leave[$a] - $enter[$a], 5);
        }

        $ranking = collect($net)
                    ->map(fn($v, $k) => ['siswa_id' => $k, 'net' => $v])
                    ->sortByDesc('net')
                    ->values()
                    ->all();

        return compact('matrix', 'bobot', 'pref',
                       'leave', 'enter', 'net',
                       'ranking', 'siswaNames', 'kriteriaMeta', 'perhitunganDetail');
    }
}
