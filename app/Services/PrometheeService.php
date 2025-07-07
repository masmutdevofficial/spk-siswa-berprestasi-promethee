<?php

namespace App\Services;

use App\Models\Siswa;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\NilaiPrestasi;

class PrometheeService
{
    /**
     * Hitung PROMETHEE detail untuk satu kelas & periode.
     *
     * @return array [
     *   'matrix'      => [siswa_id][kriteria_id] => nilai,
     *   'bobot'       => [kriteria_id]           => bobot,
     *   'pref'        => [a][b]                  => π(a,b),
     *   'leave'       => [siswa_id]              => φ⁺,
     *   'enter'       => [siswa_id]              => φ⁻,
     *   'net'         => [siswa_id]              => φ,
     *   'ranking'     => urutan net flow desc,
     *   'siswaNames'  => [siswa_id]              => nama_siswa,
     *   'kriteriaMeta'=> [kriteria_id]           => ['kode'=>…,'nama'=>…],
     * ]
     */
    public function hitungDetailed(int $kelasId, int $periodeId): array
    {
        /* ---------- mapping kriteria prestasi per jenjang ---------- */
        $prestasiMap       = [1 => 37, 2 => 56, 3 => 75];
        $kriteriaPrestasi  = $prestasiMap[$kelasId] ?? null;

        /* ---------- data siswa (id + nama) ---------- */
        $siswaColl  = Siswa::where('kelas_id', $kelasId)
                        ->orderBy('siswa_id')
                        ->get(['siswa_id', 'nama_siswa']);

        $siswaIds   = $siswaColl->pluck('siswa_id')->toArray();
        $siswaNames = $siswaColl->pluck('nama_siswa', 'siswa_id')->toArray();

        /* ---------- data kriteria (plus prestasi) ---------- */
        $kriteria   = Kriteria::where('sekolah_id', $kelasId)
                        ->with('bobot')
                        ->orderBy('kriteria_id')
                        ->get(['kriteria_id', 'kode_kriteria', 'nama_kriteria', 'sekolah_id']);

        if ($kriteriaPrestasi && !$kriteria->contains('kriteria_id', $kriteriaPrestasi)) {
            $kp = Kriteria::with('bobot')->find($kriteriaPrestasi);
            if ($kp) $kriteria->push($kp);
        }

        $kriteriaIds = $kriteria->pluck('kriteria_id')->toArray();

        /* meta kriteria */
        $kriteriaMeta = [];
        $bobot        = [];
        foreach ($kriteria as $k) {
            $kriteriaMeta[$k->kriteria_id] = [
                'kode' => $k->kode_kriteria,
                'nama' => $k->nama_kriteria,
            ];
            $bobot[$k->kriteria_id] = $k->bobot->bobot ?? 0;
        }

        /* ---------- matriks nilai ---------- */
        $matrix = array_fill_keys($siswaIds, []);

        // nilai semester
        $pen = Penilaian::where('kelas_id', $kelasId)
                ->where('periode_id', $periodeId)
                ->whereIn('kriteria_id', $kriteriaIds)
                ->get();

        foreach ($pen as $p) {
            $matrix[$p->siswa_id][$p->kriteria_id] = $p->nilai_kriteria;
        }

        // nilai prestasi
        if ($kriteriaPrestasi) {
            $pres = NilaiPrestasi::where('periode_id', $periodeId)
                    ->where('kriteria_id', $kriteriaPrestasi)
                    ->get();

            foreach ($pres as $n) {
                $matrix[$n->siswa_id][$n->kriteria_id] = $n->nilai_kriteria;
            }
        }

        /* ---------- preferensi & flow ---------- */
        $pref   = [];
        $leave  = [];
        $enter  = [];
        $nAlt   = count($siswaIds) - 1;

        foreach ($siswaIds as $a) {
            $pref[$a] = [];
            foreach ($siswaIds as $b) {
                if ($a === $b) { $pref[$a][$b] = 0; continue; }

                $pi = 0;
                foreach ($kriteriaIds as $kid) {
                    $na = $matrix[$a][$kid] ?? 0;
                    $nb = $matrix[$b][$kid] ?? 0;
                    if ($na > $nb) $pi += $bobot[$kid];
                }
                $pref[$a][$b] = $pi;
            }
        }

        foreach ($siswaIds as $a) {
            $phiPlus = $phiMinus = 0;
            foreach ($siswaIds as $b) {
                if ($a === $b) continue;
                $phiPlus  += $pref[$a][$b];
                $phiMinus += $pref[$b][$a];
            }
            $leave[$a] = $nAlt ? round($phiPlus  / $nAlt, 5) : 0;
            $enter[$a] = $nAlt ? round($phiMinus / $nAlt, 5) : 0;
        }

        $net = [];
        foreach ($siswaIds as $a) {
            $net[$a] = round($leave[$a] - $enter[$a], 5);
        }

        /* ---------- ranking ---------- */
        $ranking = collect($net)
                    ->map(fn($v, $k) => ['siswa_id' => $k, 'net' => $v])
                    ->sortByDesc('net')
                    ->values()
                    ->all();

        return compact('matrix', 'bobot', 'pref',
                       'leave', 'enter', 'net',
                       'ranking', 'siswaNames', 'kriteriaMeta');
    }
}
