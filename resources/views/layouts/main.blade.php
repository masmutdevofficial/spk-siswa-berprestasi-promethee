@include('layouts.header')
@include('layouts.navbar')
@include('layouts.sidebar')
@include('layouts.alerts')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        @yield('content-header')
    </div>
</section>

<!-- Content Wrapper. Contains page content -->
<section class="content pt-3">
    <div class="container-fluid">
        @yield('content')
    </div>
</section>

@include('layouts.footer')
