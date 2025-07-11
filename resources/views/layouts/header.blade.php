<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'SISTEM PENDUKUNG KEPUTUSAN UNTUK MENENTUKAN SISWA/I BERPRESTASI DENGAN MENGGUNAKAN METODE PROMETHEE DI YAYASAN PENDIDIKAN ADVENT PAPUA' }}</title>

    <!-- REQUIRED CSS -->
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/css/adminlte.min.css') }}">

    @yield('customCss')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
