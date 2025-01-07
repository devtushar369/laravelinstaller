<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('page_title')</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="csrf_token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{ asset('vendor/laravel-installer/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('vendor/laravel-installer/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('vendor/laravel-installer/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/laravel-installer/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('vendor/laravel-installer/css/main.css') }}" rel="stylesheet">

    @stack('css')
</head>

<body class="index-page">

<main class="main">
    <!-- Hero Section -->
    <section id="hero" class="hero section">
        <div class="container-fluid">
            <div class="row align-items-start">

                @include('laravelInstaller::layout.partials.sidebar')

                <div class="col-lg-9">
                    <div class="content-body flex-fill">
                        <div class="hero-content">
                            <div class="row">
                                <div class="col-lg-10">
                                    <div class="company-badge mb-4">
                                        <i class="bi bi-signpost-2 me-2"></i>
                                        @yield('menu_title')
                                    </div>
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<!-- Vendor JS Files -->
<script src="{{ asset('vendor/laravel-installer/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Main JS File -->
{{--<script src="{{ asset('vendor/laravel-installer/js/main.js') }}"></script>--}}
<script src="{{ asset('vendor/laravel-installer/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('vendor/laravel-installer/js/sweetalert2.min.js') }}"></script>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        customClass: {
            popup: 'colored-toast'
        },
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    function loading(loading){
        if(loading){
            $('#go-next-button').prop('disabled', true);
            $('#go-next-button #text').hide();
            $('#go-next-button #loading').show();
        }else {
            $('#go-next-button').prop('disabled', false);
            $('#go-next-button #text').show();
            $('#go-next-button #loading').hide();
        }
    }
</script>
@stack('js')
</body>
</html>
