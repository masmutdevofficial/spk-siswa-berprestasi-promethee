<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan - {{ $sekolah->nama_sekolah }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: center; }
        th { background-color: #eee; }
        h2 { text-align: center; margin-top: 0; }
    </style>
</head>
<body>

    <h2>Laporan Ranking – {{ $sekolah->nama_sekolah }}</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Siswa</th>
                <th>Kelas</th>
                <th>Periode</th>
                <th>Net Flow</th>
                <th>Ranking</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->siswa->nama_siswa ?? '-' }}</td>
                    <td>{{ $item->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $item->periode->tahun_ajaran ?? '-' }}</td>
                    <td>{{ $item->net_flow }}</td>
                    <td>{{ $item->ranking }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top:20px;">
        <strong>Siswa Terbaik:</strong>
        {{ $tertinggi?->siswa->nama_siswa ?? '-' }} (Net Flow: {{ $tertinggi?->net_flow ?? '-' }})
    </p>

    <script>
        window.print();
    </script>
</body>
</html>
