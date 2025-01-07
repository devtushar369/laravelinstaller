@extends('laravelInstaller::layout.master')
@section('page_title', 'Please Verification your License')
@section('menu_title', 'License Verification')
@section('content')
    <div class="mt-3">
        <h3 class="mb-4">Please verification your license</h3>
        <form id="licenseForm">
            @csrf
            <div class="mb-4">
                <label for="access_code" class="form-label h6">Access Code <span class="text-danger fw-bold">*</span></label>
                <input type="text" id="access_code" class="form-control" name="access_code" placeholder="Access Code">
                <div class="error text-danger form-text" id="access_code_error"></div>
                <h6 class="mt-2 form-text"><i class="bi bi-info-circle"></i> Enter your purchase code to verify your license</h6>
            </div>
            <div class="mb-4">
                <label for="envato_email" class="form-label h6">Envato Email <span class="text-danger fw-bold">*</span></label>
                <input type="email" id="envato_email" class="form-control" name="envato_email" placeholder="Envato Email">
                <div class="error text-danger form-text" id="envato_email_error"></div>
                <h6 class="mt-2 form-text"><i class="bi bi-info-circle"></i> To verify your authorization, use your Envato account
                    email address</h6>
            </div>
            <div class="mb-4">
                <label for="installed_domain" class="form-label h6">Installed Domain <span class="text-danger fw-bold">*</span></label>
                <input type="url" id="installed_domain" class="form-control" value="{{ config('app.url') }}" name="domain" placeholder="Installed Domain">
                <div class="error text-danger form-text" id="installed_domain_error"></div>
                <h6 class="mt-2 form-text"><i class="bi bi-info-circle"></i> What domain or subdomain are you using to access this
                    project? This will depend on whether you want to install the project on the main domain (e.g.,
                    example.com) or a subdomain (e.g., sub.example.com).</h6>
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
            $('#licenseVerification').click(function () {
                window.location.href = "{{ route('install.license_verification') }}";
            })
        })
    </script>

    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                }
            });

            $('#licenseForm').on('submit', function (e) {
                e.preventDefault();

                // Clear previous errors
                $('.error').text('');

                // Validate form inputs
                let accessCode = $('#access_code').val().trim();
                let envatoEmail = $('#envato_email').val().trim();
                let installedDomain = $('#installed_domain').val().trim();
                let isValid = true;

                if (accessCode === '') {
                    $('#access_code_error').text('Access Code is required.');
                    isValid = false;
                }

                if (envatoEmail === '') {
                    $('#envato_email_error').text('Envato Email is required.');
                    isValid = false;
                } else if (!validateEmail(envatoEmail)) {
                    $('#envato_email_error').text('Enter a valid email address.');
                    isValid = false;
                }

                if (installedDomain === '') {
                    $('#installed_domain_error').text('Installed Domain is required.');
                    isValid = false;
                }

                if (isValid) {
                    loading(true);
                    $.ajax({
                        url: "{{ route('install.license_verification.store') }}", // Replace with your route
                        method: "POST",
                        data: {
                            access_code: accessCode,
                            envato_email: envatoEmail,
                            installed_domain: installedDomain
                        },
                        success: function (response) {
                            loading(false);
                            if(response.status == 'success'){
                                Toast.fire({
                                    icon: 'success',
                                    title: 'License verification completed successfully!'
                                }).then(() => {
                                    window.location.href = "{{ route('install.database_setup') }}";
                                });
                            }else {
                                Toast.fire({
                                    icon: 'error',
                                    title: response.message
                                })
                            }
                        },
                        error: function (xhr) {
                            loading(false);
                            const responseMessage = xhr.responseJSON?.message || 'An unexpected error occurred. Please try again.';
                            Toast.fire({
                                icon: 'error',
                                text: responseMessage,
                            });
                        }
                    });
                }
            });

            // Function to validate email
            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }
        });
    </script>
@endpush
