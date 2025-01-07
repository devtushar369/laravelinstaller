@extends('laravelInstaller::layout.master')
@section('page_title', 'Admin Setup')
@section('menu_title', 'Admin Setup')
@section('content')
    <div class="mt-3">
        <h3 class="mb-4">Admin Setup</h3>
        <form id="adminSetup">
            @csrf
            <div class="mb-4">
                <label for="email" class="form-label h6">Email<span class="text-danger fw-bold">*</span></label>
                <input type="email" id="email" class="form-control" value="" name="email" placeholder="Enter email">
                <div class="error text-danger form-text" id="email_error"></div>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label h6">Password<span class="text-danger fw-bold">*</span></label>
                <input type="password" id="password" class="form-control" value="" name="password"
                       placeholder="Enter Password">
                <div class="error text-danger form-text" id="password_error"></div>
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="form-label h6">Password Confirmation<span
                        class="text-danger fw-bold">*</span></label>
                <input type="password" id="password_confirmation" class="form-control" value=""
                       name="password_confirmation" placeholder="Enter Password">
                <div class="error text-danger form-text" id="password_confirmation_error"></div>
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input name="demo_data" type="hidden" value="0">
                    <input class="form-check-input" name="demo_data" type="checkbox" value="1" id="demo_data">
                    <label class="form-check-label" for="demo_data">
                        Install With Demo Data
                    </label>
                </div>
            </div>

            <div class="hero-buttons mt-4 text-center">
                <button id="go-next-button" type="submit" class="btn btn-primary me-0 me-sm-2 mx-1">
                    <span id="loading" style="display: none">
                        <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                        <span role="status">Loading...</span>
                    </span>
                    <span id="text">Go to Next <i class="bi bi-arrow-right"></i></span>
                </button>
            </div>

        </form>


    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                }
            });

            $('#adminSetup').on('submit', function (e) {
                e.preventDefault();
                $('.error').text('');

                let email = $('#email').val().trim();
                let password = $('#password').val().trim();
                let passwordConfirmation = $('#password_confirmation').val().trim();
                let demoData = $('#demo_data').is(':checked') ? 1 : 0;

                let isValid = true;

                // Validate email
                if (email === '') {
                    $('#email_error').text('Email is required.');
                    isValid = false;
                } else if (!validateEmail(email)) {
                    $('#email_error').text('Enter a valid email address.');
                    isValid = false;
                }

                // Validate password
                if (password === '') {
                    $('#password_error').text('Password is required.');
                    isValid = false;
                } else if (password.length < 6) {
                    $('#password_error').text('Password must be at least 6 characters.');
                    isValid = false;
                }

                // Validate password confirmation
                if (passwordConfirmation === '') {
                    $('#password_confirmation_error').text('Password confirmation is required.');
                    isValid = false;
                } else if (password !== passwordConfirmation) {
                    $('#password_confirmation_error').text('Passwords do not match.');
                    isValid = false;
                }

                if (isValid) {
                    // Submit the form using AJAX
                    loading(true);
                    $.ajax({
                        url: "{{ route('install.admin_setup.store') }}", // Replace with your Laravel route
                        method: "POST",
                        data: {
                            _token: $('meta[name="csrf_token"]').attr('content'), // Get CSRF token from meta tag
                            email: email,
                            password: password,
                            password_confirmation: passwordConfirmation,
                            demo_data: demoData
                        },
                        success: function (response) {
                            loading(false);
                            Toast.fire({
                                icon: 'success',
                                title: 'Admin setup completed successfully!'
                            }).then(() => {
                                window.location.href = "{{ route('install.completed') }}"; // Replace with your route
                            });
                        },
                        error: function (xhr) {
                            loading(false);
                            // Handle validation errors from the backend
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                let errors = xhr.responseJSON.errors;
                                if (errors.email) {
                                    $('#email_error').text(errors.email[0]);
                                }
                                if (errors.password) {
                                    $('#password_error').text(errors.password[0]);
                                }
                                if (errors.password_confirmation) {
                                    $('#password_confirmation_error').text(errors.password_confirmation[0]);
                                }
                            } else {
                                Toast.fire({
                                    icon: 'error',
                                    title: 'An error occurred while processing your request'
                                })
                            }
                        }
                    });
                }
            });

            // Email validation function
            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }
        });

    </script>
@endpush
