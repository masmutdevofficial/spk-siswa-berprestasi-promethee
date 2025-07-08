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
            <h3 class="card-title">Data Penilaian</h3>
            <div>
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
                    <i class="fa fa-plus mr-2"></i>Tambah Penilaian
                </button>
                <button class="btn btn-success" data-toggle="modal" data-target="#modalTambahPrestasi">
                    <i class="fa fa-star mr-2"></i>Tambah Nilai Prestasi
                </button>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table id="basicTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Kriteria</th>
                    <th>Periode</th>
                    <th>Semester</th>
                    <th>Nilai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->siswa->nama_siswa ?? '-' }}</td>
                    <td>{{ $item->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $item->kriteria->nama_kriteria ?? '-' }}</td>
                    <td>{{ $item->periode->tahun_ajaran ?? '-' }}</td>
                    <td>{{ $item->semester->nama ?? '-' }}</td>
                    <td>{{ $item->nilai_kriteria }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-warning mr-2 btn-edit"
                                data-id="{{ $item->penilaian_id }}">
                            <i class="fa fa-edit mr-1"></i>Edit
                        </button>

                        <button class="btn btn-sm btn-danger btn-hapus"
                                data-id="{{ $item->penilaian_id }}"
                                data-nama="{{ $item->siswa->nama_siswa }}">
                            <i class="fa fa-trash mr-1"></i>Hapus
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Nilai Prestasi -->
<div class="modal fade" id="modalTambahPrestasi" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ url('/nilai-prestasi/store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Nilai Prestasi</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="siswa_id">Siswa</label>
                        <select name="siswa_id" id="siswa_id" class="form-control" required>
                            <option value="" disabled selected>Pilih Siswa</option>
                            @foreach($siswa as $s)
                                <option value="{{ $s->siswa_id }}" {{ old('siswa_id') == $s->siswa_id ? 'selected' : '' }}>
                                    {{ $s->nama_siswa }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="kriteria_id">Kriteria</label>
                        <select name="kriteria_id" id="kriteria_id" class="form-control" required>
                            <option value="" disabled selected>Pilih Kriteria</option>
                            @foreach($kriteriaPrestasi as $kr)
                                <option value="{{ $kr->kriteria_id }}" {{ old('kriteria_id') == $kr->kriteria_id ? 'selected' : '' }}>
                                    {{ $kr->nama_kriteria }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="periode_id">Periode</label>
                        <select name="periode_id" id="periode_id" class="form-control" required>
                            <option value="" disabled selected>Pilih Periode</option>
                            @foreach($periode as $p)
                                <option value="{{ $p->periode_id }}" {{ old('periode_id') == $p->periode_id ? 'selected' : '' }}>
                                    {{ $p->tahun_ajaran }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nilai_kriteria">Nilai</label>
                        <input type="number" step="0.01" name="nilai_kriteria" id="nilai_kriteria"
                               class="form-control" value="{{ old('nilai_kriteria') }}" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>


{{-- ───────────────────────── Modal Edit Global ───────────────────────── --}}
<div class="modal fade" id="modalEditGlobal" tabindex="-1">
    <div class="modal-dialog">
        <form id="formEditPenilaian" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Penilaian</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="editModalContent">
                    <p class="text-center m-0">Memuat&nbsp;<i class="fa fa-spinner fa-spin"></i></p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus Global -->
<div class="modal fade" id="modalHapusGlobal" tabindex="-1">
    <div class="modal-dialog">
        <form id="formHapusPenilaian" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    Yakin ingin menghapus penilaian untuk
                    <strong id="hapusNamaSiswa">siswa ini</strong>?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ url('penilaian/store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Penilaian</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Siswa</label>
                        <select name="siswa_id" class="form-control" required>
                            @foreach($siswa as $s)
                            <option value="{{ $s->siswa_id }}">{{ $s->nama_siswa }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Kelas</label>
                        <select name="kelas_id" class="form-control" required>
                            @foreach($kelas as $k)
                            <option value="{{ $k->kelas_id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Kriteria</label>
                        <select name="kriteria_id" class="form-control" required>
                            @foreach($kriteria as $kr)
                            <option value="{{ $kr->kriteria_id }}">{{ $kr->nama_kriteria }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Periode</label>
                        <select name="periode_id" class="form-control" required>
                            @foreach($periode as $p)
                            <option value="{{ $p->periode_id }}">{{ $p->tahun_ajaran }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Semester</label>
                        <select name="semester_id" class="form-control" required>
                            @foreach($semuaSemester as $sm)
                            <option value="{{ $sm->semester_id }}">{{ $sm->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Nilai</label>
                        <input type="number" step="0.01" name="nilai_kriteria" class="form-control" required>
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
    // DataTables
    $("#basicTable").DataTable({
        responsive: true,
        lengthChange: true,
        autoWidth: false,
        lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]]
    });

    // ───────────────────────── tombol EDIT ─────────────────────────
    $('.btn-edit').on('click', function () {
        const id = $(this).data('id');
        $('#editModalContent').html('<p class="text-center m-0">Memuat&nbsp;<i class="fa fa-spinner fa-spin"></i></p>');
        $('#modalEditGlobal').modal('show');

        $.get(`/penilaian/edit/${id}`, function (res) {
            $('#editModalContent').html(res.form);
            $('#formEditPenilaian').attr('action', `/penilaian/update/${id}`);
        });
    });

    // ───────────────────────── tombol HAPUS ─────────────────────────
    $('.btn-hapus').on('click', function () {
        const id   = $(this).data('id');
        const nama = $(this).data('nama');

        // isi data di modal
        $('#hapusNamaSiswa').text(nama);
        $('#formHapusPenilaian').attr('action', '/penilaian/delete/' + id);

        $('#modalHapusGlobal').modal('show');
    });
});
</script>
<script>
    const nilaiPrestasiTersimpan = @json($nilaiPrestasiTersimpan);

    function updateNilaiPrestasiAuto() {
        const siswaId    = $('#siswa_id').val();
        const kriteriaId = $('#kriteria_id').val();
        const periodeId  = $('#periode_id').val();

        const key = `${siswaId}-${kriteriaId}-${periodeId}`;
        if (nilaiPrestasiTersimpan[key] !== undefined) {
            $('#nilai_kriteria').val(nilaiPrestasiTersimpan[key]);
        } else {
            $('#nilai_kriteria').val('');
        }
    }

    $('#siswa_id, #kriteria_id, #periode_id').on('change', updateNilaiPrestasiAuto);
</script>
@endsection
