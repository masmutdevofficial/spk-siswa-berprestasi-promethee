@extends('layouts.main')

@section('customCss')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<!-- Tabler Icons -->
<link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler.min.css') }}">
@endsection



@section('customJs')
<!-- DataTables & Plugins -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
@endsection

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Data Ranking</h3>

            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownAlgoritma" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-code mr-2"></i> Mulai Algoritma
                </button>
                @php
                    $sekolah_id = Auth::guard('user_guru')->user()->sekolah_id;

                    // Ambil kelas dari sekolah user login
                    $kelasList = \App\Models\Kelas::where('sekolah_id', $sekolah_id)->get();

                    // Map label kelas berdasarkan nama_kelas (bebas kamu ubah jika pola beda)
                    $labelMap = [
                        '6A'      => 'SD - 6A',
                        '9D'      => 'SMP - 9D',
                        '12 IPA'  => 'SMA - 12 IPA',
                    ];
                @endphp

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownAlgoritma">
                    @foreach ($kelasList as $kelas)
                        @php
                            $label = $labelMap[$kelas->nama_kelas] ?? $kelas->nama_kelas;
                        @endphp
                        <a class="dropdown-item" href="{{ url('/promethee/' . $kelas->kelas_id) }}">
                            Hitung {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table id="basicTable" class="table table-bordered table-striped">
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
    </div>

    <div class="alert alert-success mx-3">
        Siswa Terbaik:
        <strong>{{ $tertinggi?->siswa->nama_siswa ?? '-' }}</strong>
        (Net Flow: {{ $tertinggi?->net_flow ?? '-' }})
    </div>
</div>

@endsection

@section('bodyJs')
<script>
  $(function () {
    $("#basicTable").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "lengthMenu": [ [5, 10, 25, 50, 100], [5, 10, 25, 50, 100] ]
    });
  });
</script>
@endsection
