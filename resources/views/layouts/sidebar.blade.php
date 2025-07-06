<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    @php
        $role = session('role');
        $label = match ($role) {
            'admin_yayasan' => 'Admin Yayasan',
            'admin_sekolah' => 'Admin Sekolah',
            'user_guru' => 'Guru',
            default => 'Admin',
        };
    @endphp

    <a href="{{ url('/') }}" class="brand-link d-flex justify-content-center align-items-center">
        <span class="brand-text font-weight-light font-weight-bold">{{ $label }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        @php
            $role = session('role');
        @endphp

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                {{-- ADMIN YAYASAN --}}
                @if ($role === 'admin_yayasan')
                    <li class="nav-item">
                        <a href="{{ url('admin-yayasan') }}" class="nav-link {{ request()->is('admin-yayasan') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>Admin Yayasan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('yayasan') }}" class="nav-link {{ request()->is('yayasan') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-building"></i>
                            <p>Yayasan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('sekolah') }}" class="nav-link {{ request()->is('sekolah') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-school"></i>
                            <p>Sekolah</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('admin-sekolah') }}" class="nav-link {{ request()->is('admin-sekolah') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-tie"></i>
                            <p>Admin Sekolah</p>
                        </a>
                    </li>
                @endif

                {{-- ADMIN SEKOLAH --}}
                @if ($role === 'admin_sekolah')
                    <li class="nav-item">
                        <a href="{{ url('user-guru') }}" class="nav-link {{ request()->is('user-guru') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chalkboard-teacher"></i>
                            <p>Guru</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('kelas') }}" class="nav-link {{ request()->is('kelas') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-door-open"></i>
                            <p>Kelas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('kriteria') }}" class="nav-link {{ request()->is('kriteria') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>Kriteria</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('bobot-kriteria') }}" class="nav-link {{ request()->is('bobot-kriteria') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-weight-hanging"></i>
                            <p>Bobot Kriteria</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('semester') }}" class="nav-link {{ request()->is('semester') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar"></i>
                            <p>Semester</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('periode') }}" class="nav-link {{ request()->is('periode') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-week"></i>
                            <p>Periode</p>
                        </a>
                    </li>
                @endif

                {{-- GURU --}}
                @if ($role === 'user_guru')
                    <li class="nav-item">
                        <a href="{{ url('siswa') }}" class="nav-link {{ request()->is('siswa') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Siswa</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('penilaian') }}" class="nav-link {{ request()->is('penilaian') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-pencil-alt"></i>
                            <p>Penilaian</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('ranking') }}" class="nav-link {{ request()->is('ranking') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p>Ranking</p>
                        </a>
                    </li>
                @endif

            </ul>
        </nav>



        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
