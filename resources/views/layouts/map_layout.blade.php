<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
    <!-- Include Leaflet from CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
</head>

<body>
    <div id="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center">
            <img src="{{ asset('vendor/adminlte/dist/img/logo.png') }}" class="animation__shake"
                alt="AdminLTE Preloader Image" width="400" height="400">
        </div>
        <div id="content">
            @yield('content')
        </div>

        <footer class="main-footer">
            <div id="mycredit" class="small text-center"><strong> Copyright &copy;
                    2023 Sistem Informasi New Open Order - Dimas Ananto Pratama </div>
        </footer>
    </div>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    <!-- Include Leaflet from CDN -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <!-- Add any other scripts -->
    @yield('js')
</body>

</html>
