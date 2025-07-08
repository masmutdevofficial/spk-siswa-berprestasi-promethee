{{-- variabel tersedia: $penilaian, $siswa, $kelas, $kriteria, $periode, $semuaSemester --}}
<div class="mb-3">
    <label>Siswa</label>
    <select name="siswa_id" class="form-control" required>
        @foreach($siswa as $s)
        <option value="{{ $s->siswa_id }}" {{ $penilaian->siswa_id == $s->siswa_id ? 'selected' : '' }}>
            {{ $s->nama_siswa }}
        </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Kelas</label>
    <select name="kelas_id" class="form-control" required>
        @foreach($kelas as $k)
        <option value="{{ $k->kelas_id }}" {{ $penilaian->kelas_id == $k->kelas_id ? 'selected' : '' }}>
            {{ $k->nama_kelas }}
        </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Kriteria</label>
    <select name="kriteria_id" class="form-control" required>
        @foreach($kriteria as $kr)
        <option value="{{ $kr->kriteria_id }}" {{ $penilaian->kriteria_id == $kr->kriteria_id ? 'selected' : '' }}>
            {{ $kr->nama_kriteria }}
        </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Periode</label>
    <select name="periode_id" class="form-control" required>
        @foreach($periode as $p)
        <option value="{{ $p->periode_id }}" {{ $penilaian->periode_id == $p->periode_id ? 'selected' : '' }}>
            {{ $p->tahun_ajaran }}
        </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Semester</label>
    <select name="semester_id" class="form-control" required>
        @foreach($semuaSemester as $sm)
        <option value="{{ $sm->semester_id }}" {{ $penilaian->semester_id == $sm->semester_id ? 'selected' : '' }}>
            {{ $sm->nama }}
        </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Nilai</label>
    <input type="number" step="0.01"
           name="nilai_kriteria"
           value="{{ $penilaian->nilai_kriteria }}"
           class="form-control" required>
</div>
