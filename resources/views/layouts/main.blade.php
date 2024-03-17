<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Jaya Gupta - @yield('title')</title>

    <meta name="msapplication-TileImage" content="https://www.pendidikan.denpasarkota.go.id/public/images/favicon.png">
        <meta name="msapplication-TileImage" content="https://www.pendidikan.denpasarkota.go.id/public/images/favicon.png">
        <meta name="msapplication-TileColor" content="#f4e4d7">
        <meta name="theme-color" content="#f4e4d7">
            
        <link rel="shortcut icon" href="https://www.pendidikan.denpasarkota.go.id/public/images/favicon.png">
        <link rel="apple-touch-icon" href="https://www.pendidikan.denpasarkota.go.id/public/images/favicon.png">
        <link rel="apple-touch-icon" sizes="152x152" href="https://www.pendidikan.denpasarkota.go.id/public/images/favicon.png">
        <link rel="apple-touch-icon" sizes="180x180" href="https://www.pendidikan.denpasarkota.go.id/public/images/favicon.png">
        <link rel="apple-touch-icon" sizes="167x167" href="https://www.pendidikan.denpasarkota.go.id/public/images/favicon.png">
        <link rel="icon" href="https://www.pendidikan.denpasarkota.go.id/public/images/favicon.png" sizes="32x32" />
        <link rel="icon" href="https://www.pendidikan.denpasarkota.go.id/public/images/favicon.png" sizes="192x192" />
        <link rel="apple-touch-icon" href="https://www.pendidikan.denpasarkota.go.id/public/images/favicon.png" />
        <link rel="mask-icon" href="https://www.pendidikan.denpasarkota.go.id/public/images/favicon.png" color="#f4e4d7">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/bootstrap/css/bootstrap.min.css">
    
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/style.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/components.css">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/izitoast/css/iziToast.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    {{-- Custom CSS --}}
    @stack('css-custom')
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            @include('layouts.header')
            @include('layouts.navbar')

            <!-- Main Content -->
            @yield('container')
            {{-- End Main Content --}}

            @include('layouts.footer')
        </div>
    </div>
    <!-- General JS Scripts -->
    <script src="{{ URL::to('/') }}/assets/modules/jquery.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/modules/popper.js"></script>
    <script src="{{ URL::to('/') }}/assets/modules/tooltip.js"></script>
    <script src="{{ URL::to('/') }}/assets/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/modules/moment.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/stisla.js"></script>
    <script src="{{ URL::to('/') }}/assets/modules/izitoast/js/iziToast.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>

    <!-- JS Libraies -->

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="{{ URL::to('/') }}/assets/js/scripts.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/custom.js"></script>
    <script>
        // ** CSRF Token * //
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>

    {{-- Custom JS --}}
    @stack('js-custom')

    @if (session()->has('success'))
        <script>
            $(document).ready(function() {
                iziToast.success({
                    title: 'Berhasil !',
                    message: "{{ session('success') }}",
                    position: 'topRight'
                });
            });
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            $(document).ready(function() {
                iziToast.danger({
                    title: 'Berhasil !',
                    message: "{{ session('error') }}",
                    position: 'topRight'
                });
            });
        </script>
    @endif
</body>

</html>
