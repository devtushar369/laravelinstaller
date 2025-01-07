@extends('laravelInstaller::layout.master')
@section('page_title', 'Complete Installation and Configuration')
@section('menu_title', 'Installation Finished')
@section('content')
    <div class="mt-5 text-center">
        <h1 class="mb-4">
            Complete the Installation and Configuration
        </h1>
        <p class="accent-text">Congratulations! You successfully installed the application</p>
        <p>Email : {{ @$email }}</p>

        <p> Password : {{ @$password }}</p>
        <div class="hero-buttons">
            <a href="{{ url('/') }}" id="getStarted" class="btn btn-primary me-0 me-sm-2 mx-1">
                Go to Home <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
@endsection
