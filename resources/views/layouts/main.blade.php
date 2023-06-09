<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Jaya Gupta - @yield('title')</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/style.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/components.css">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
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
  
  <!-- JS Libraies -->

  <!-- Page Specific JS File -->
  
  <!-- Template JS File -->
  <script src="{{ URL::to('/') }}/assets/js/scripts.js"></script>
  <script src="{{ URL::to('/') }}/assets/js/custom.js"></script>

  {{-- Custom JS --}}
   @stack('js-custom')
</body>

</html>
