@extends('laravelInstaller::layout.master')
@section('page_title', 'Welcome to Installation')
@section('menu_title', 'Welcome')
@section('content')
    <div class="mt-5 text-center">
        <h1 class="mb-4">
            Welcome to
        </h1>
        <h1 class="mb-4">
            <span class="accent-text">Hashcode Laravel Installer</span>
        </h1>
        <p>To complete the installation, please proceed to the next step!</p>
        <div class="hero-buttons">
            <a href="javascript:" id="getStarted" class="btn btn-primary me-0 me-sm-2 mx-1">
                Get Started <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#getStarted').click(function () {
                window.location.href = "{{ route('install.check_requirement') }}";
            })
        })
    </script>
@endpush
