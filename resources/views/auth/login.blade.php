<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Jaya Gupta &mdash; Login</title>
    <meta name="msapplication-TileImage" content="https://www.pendidikan.denpasarkota.go.id/public/images/favicon.png">
    <meta name="msapplication-TileImage" content="https://www.pendidikan.denpasarkota.go.id/public/images/favicon.png">
    <meta name="msapplication-TileColor" content="#f4e4d7">
    <meta name="theme-color" content="#f4e4d7">

    <link rel="shortcut icon" href="https://www.pendidikan.denpasarkota.go.id/public/images/favicon.png">
    <link rel="apple-touch-icon" href="https://www.pendidikan.denpasarkota.go.id/public/images/favicon.png">
    <link rel="apple-touch-icon" sizes="152x152"
        href="https://www.pendidikan.denpasarkota.go.id/public/images/favicon.png">
    <link rel="apple-touch-icon" sizes="180x180"
        href="https://www.pendidikan.denpasarkota.go.id/public/images/favicon.png">
    <link rel="apple-touch-icon" sizes="167x167"
        href="https://www.pendidikan.denpasarkota.go.id/public/images/favicon.png">
    <link rel="icon" href="https://www.pendidikan.denpasarkota.go.id/public/images/favicon.png" sizes="32x32" />
    <link rel="icon" href="https://www.pendidikan.denpasarkota.go.id/public/images/favicon.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://www.pendidikan.denpasarkota.go.id/public/images/favicon.png" />
    <link rel="mask-icon" href="https://www.pendidikan.denpasarkota.go.id/public/images/favicon.png" color="#f4e4d7">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/bootstrap-social/bootstrap-social.css">

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
    <!-- /END GA -->
</head>
<style>
    .myimage {
        display: block;
        /* margin-left: auto;
        margin-right: auto; */
    }
</style>
{{-- <style>
     body {
   background-image: url("https://www.denpasarkota.go.id/assets/CKImages/images/Patung-Titi-Banda(1).jpg");
   background-repeat: no-repeat;
   background-size:cover
}
</style> --}}

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div
                        class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <img src="https://www.pendidikan.denpasarkota.go.id/public/uploads/header_192106040650_.png"
                            width="100%" alt="logo" class="myimage img-fluid">
                        <div class="login-brand">

                            <h1 style="color: black">JAYA GUPTA</h1>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Login</h4>
                            </div>
                            <div class="card-body">

                                {{-- @if (session()->has('LoginError'))
                                    <div class="alert alert-danger d-flex justify-content-center" role="alert">
                                        {{ session('LoginError') }}
                                    </div>
                                @endif --}}
                                <form method="POST" action="/login" class="needs-validation" novalidate="">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control" name="email"
                                            tabindex="1" required autofocus>
                                        <div class="invalid-feedback">
                                            Mohon diisi email Anda !
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                            {{-- <div class="float-right">
                                                <a href="auth-forgot-password.html" class="text-small">
                                                    Forgot Password?
                                                </a>
                                            </div> --}}
                                        </div>
                                        <input id="password" type="password" class="form-control" name="password"
                                            tabindex="2" required>
                                        <div class="invalid-feedback">
                                            Mohon diisi password Anda !
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Login
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- <div class="mt-5 text-muted text-center">
                            Belum Memiliki Akun? <a href="auth-register.html">Daftar</a>
                        </div> --}}
                        <div class="simple-footer">                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
</body>

</html>
