<!DOCTYPE html>
<html>
<head>
    <title>Laporan Rekomendasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #444;
            padding: 6px 8px;
            text-align: center;
        }
        th {
            background-color: #eee;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="no-print" style="text-align:right">
        <button onclick="window.print()">Print</button>
    </div>

    <h2>Laporan Rekomendasi</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Periode</th>
                <th>Net Flow</th>
                <th>Ranking</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
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

</body>
</html>
