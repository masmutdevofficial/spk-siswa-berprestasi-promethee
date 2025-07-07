<!DOCTYPE html>
<html>
<head>
    <title>PROMETHEE Detail</title>
    <style>
        body   { font-family: Arial, sans-serif; font-size: 14px; }
        table  { border-collapse:collapse; width:100%; margin-bottom:25px; }
        th,td  { border:1px solid #ccc; padding:6px; text-align:center; font-size:12px; }
        th     { background:#eee; }
        h3     { margin-top:30px; }
        small  { font-size:11px; color:#555; }
    </style>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async
        src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js">
    </script>
</head>
<body>

    <h2>PROMETHEE – Detail Perhitungan (Kelas 6A)</h2>

    {{-- 0. Rumus --}}
    @verbatim
    <h3>0. Rumus PROMETHEE</h3>
    <p>Fungsi preferensi untuk setiap alternatif:</p>
    <p>\[
        \pi(a, b) = \sum_{j=1}^{n} w_j \cdot P_j(a, b)
    \]</p>

    <p>Leaving Flow (φ⁺):</p>
    <p>\[
        \phi^+(a) = \frac{1}{n - 1} \sum_{x \in A, x \ne a} \pi(a, x)
    \]</p>

    <p>Entering Flow (φ⁻):</p>
    <p>\[
        \phi^-(a) = \frac{1}{n - 1} \sum_{x \in A, x \ne a} \pi(x, a)
    \]</p>

    <p>Net Flow (φ):</p>
    <p>\[
        \phi(a) = \phi^+(a) - \phi^-(a)
    \]</p>
    @endverbatim

    {{-- Kriteria yang dipakai --}}
    @php
        $kriteriaIds = collect($detail['matrix'])
            ->flatMap(fn($row) => array_keys($row))
            ->unique()
            ->sort()
            ->values();
    @endphp

    {{-- 1. Matriks Nilai --}}
    <h3>1. Matriks Nilai (Siswa × Kriteria)</h3>
    <table>
        <thead>
            <tr>
                <th>Siswa \ Kriteria</th>
                @foreach($kriteriaIds as $kid)
                    <th>
                        {{ $detail['kriteriaMeta'][$kid]['kode'] }}<br>
                        <small>{{ $detail['kriteriaMeta'][$kid]['nama'] }}</small>
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($detail['matrix'] as $sid => $row)
                <tr>
                    <td>
                        {{ $sid }}<br>
                        <small>{{ $detail['siswaNames'][$sid] ?? '' }}</small>
                    </td>
                    @foreach($kriteriaIds as $kid)
                        <td>{{ $row[$kid] ?? 0 }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- 2. Bobot --}}
    <h3>2. Bobot Kriteria</h3>
    <table>
        <thead>
            <tr><th>Kode Kriteria</th><th>Nama Kriteria</th><th>Bobot</th></tr>
        </thead>
        <tbody>
            @foreach($kriteriaIds as $kid)
                <tr>
                    <td>{{ $detail['kriteriaMeta'][$kid]['kode'] }}</td>
                    <td>{{ $detail['kriteriaMeta'][$kid]['nama'] }}</td>
                    <td>{{ $detail['bobot'][$kid] ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- 3. Matriks Preferensi π(a,b) --}}
    <h3>3. Matriks Preferensi π(a,b)</h3>
    <table>
        <thead>
            <tr>
                <th>a \ b</th>
                @foreach(array_keys($detail['pref']) as $sid)
                    <th>{{ $sid }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($detail['pref'] as $a => $cols)
                <tr>
                    <td>{{ $a }}</td>
                    @foreach($cols as $b => $val)
                        <td>{{ $val }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- 4. Leaving / Entering / Net --}}
    <h3>4. Leaving, Entering, Net Flow</h3>
    <table>
        <thead>
            <tr>
                <th>Siswa</th>
                <th>φ⁺ (Leaving)</th>
                <th>φ⁻ (Entering)</th>
                <th>Net</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detail['net'] as $sid => $net)
                <tr>
                    <td>
                        {{ $sid }}<br>
                        <small>{{ $detail['siswaNames'][$sid] ?? '' }}</small>
                    </td>
                    <td>{{ $detail['leave'][$sid] }}</td>
                    <td>{{ $detail['enter'][$sid] }}</td>
                    <td>{{ $net }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- 5. Ranking --}}
    <h3>5. Ranking Akhir (PROMETHEE II)</h3>
    <table>
        <thead>
            <tr><th>Rank</th><th>Siswa</th><th>Net Flow</th></tr>
        </thead>
        <tbody>
            @foreach($detail['ranking'] as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        {{ $row['siswa_id'] }}<br>
                        <small>{{ $detail['siswaNames'][$row['siswa_id']] ?? '' }}</small>
                    </td>
                    <td>{{ $row['net'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
