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
            <h3 class="card-title">Data Kriteria</h3>
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
                <i class="fa fa-plus mr-2"></i>Tambah Kriteria
            </button>
        </div>
    </div>

    <div class="card-body">
        <table id="basicTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Kriteria</th>
                    <th>Jenis</th>
                    <th>Sekolah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->kode_kriteria }}</td>
                    <td>{{ $item->nama_kriteria }}</td>
                    <td>{{ ucfirst($item->jenis) }}</td>
                    <td>{{ $item->sekolah->nama_sekolah ?? '-' }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-target="#modalEdit{{ $item->kriteria_id }}">
                                <i class="fa fa-edit mr-1"></i>Edit
                            </button>
                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapus{{ $item->kriteria_id }}">
                                <i class="fa fa-trash mr-1"></i>Hapus
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEdit{{ $item->kriteria_id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ url('kriteria/update/' . $item->kriteria_id) }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Kriteria</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Kode Kriteria</label>
                                        <input type="text" name="kode_kriteria" value="{{ $item->kode_kriteria }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Nama Kriteria</label>
                                        <input type="text" name="nama_kriteria" value="{{ $item->nama_kriteria }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Jenis</label>
                                        <select name="jenis" class="form-control" required>
                                            <option value="benefit" {{ $item->jenis == 'benefit' ? 'selected' : '' }}>Benefit</option>
                                            <option value="cost" {{ $item->jenis == 'cost' ? 'selected' : '' }}>Cost</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Sekolah</label>
                                        <select name="sekolah_id" class="form-control" required>
                                            @foreach($sekolah as $s)
                                            <option value="{{ $s->sekolah_id }}" {{ $item->sekolah_id == $s->sekolah_id ? 'selected' : '' }}>
                                                {{ $s->nama_sekolah }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-warning">Update</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Hapus -->
                <div class="modal fade" id="modalHapus{{ $item->kriteria_id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ url('kriteria/delete/' . $item->kriteria_id) }}" method="GET">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    Yakin ingin menghapus kriteria <strong>{{ $item->nama_kriteria }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ url('kriteria/store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kriteria</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Kode Kriteria</label>
                        <input type="text" name="kode_kriteria" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Nama Kriteria</label>
                        <input type="text" name="nama_kriteria" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Jenis</label>
                        <select name="jenis" class="form-control" required>
                            <option value="benefit">Benefit</option>
                            <option value="cost">Cost</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Sekolah</label>
                        <select name="sekolah_id" class="form-control" required>
                            @foreach($sekolah as $s)
                            <option value="{{ $s->sekolah_id }}">{{ $s->nama_sekolah }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
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
