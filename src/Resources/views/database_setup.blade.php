@extends('laravelInstaller::layout.master')
@section('page_title', 'Check Database Setup and Connection')
@section('menu_title', 'Database Setup')
@section('content')
    <div class="mt-3">
        <h3 class="mb-4">Check Database Setup and Connection</h3>
        <form id="databaseSetupForm">
            @csrf
            <div class="mb-4">
                <label for="database_host" class="form-label h6">Database Host<span class="text-danger fw-bold">*</span></label>
                <input type="text" id="database_host" class="form-control" value="{{ config('database.connections.mysql.host') }}" name="database_host" placeholder="127.0.0.1">
                <div class="error text-danger form-text" id="database_host_error"></div>
            </div>
            <div class="mb-4">
                <label for="database_port" class="form-label h6">Database Port<span class="text-danger fw-bold">*</span></label>
                <input type="number" id="database_port" class="form-control" value="{{ config('database.connections.mysql.port') }}" name="database_port" placeholder="3306">
                <div class="error text-danger form-text" id="database_port_error"></div>
            </div>
            <div class="mb-4">
                <label for="database_name" class="form-label h6">Database Name<span class="text-danger fw-bold">*</span></label>
                <input type="text" id="database_name" class="form-control" value="{{ config('database.connections.mysql.database') }}" name="database_name" placeholder="Database Name">
                <div class="error text-danger form-text" id="database_name_error"></div>
            </div>
            <div class="mb-4">
                <label for="database_username" class="form-label h6">Database Username<span class="text-danger fw-bold">*</span></label>
                <input type="text" id="database_username" class="form-control" value="{{ config('database.connections.mysql.username') }}" name="database_username" placeholder="Database Username">
                <div class="error text-danger form-text" id="database_username_error"></div>
            </div>
            <div class="mb-4">
                <label for="database_password" class="form-label h6">Database Password</label>
                <input type="password" id="database_password" class="form-control" value="{{ config('database.connections.mysql.password') }}" name="database_password" placeholder="Database password">
                <div class="error text-danger form-text" id="database_password_error"></div>
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

            $('#databaseSetupForm').on('submit', function (e) {
                e.preventDefault();

                // Clear previous errors
                $('.error').text('');

                // Validate form inputs
                let db_host = $('#database_host').val().trim();
                let db_port = $('#database_port').val().trim();
                let db_name = $('#database_name').val().trim();
                let db_username = $('#database_username').val().trim();
                let db_password = $('#database_password').val().trim();
                let isValid = true;

                if (db_host === '') {
                    $('#database_host_error').text('Database host is required.');
                    isValid = false;
                }

                if (db_port === '') {
                    $('#database_port_error').text('Database port is required.');
                    isValid = false;
                }

                if (db_name === '') {
                    $('#database_name_error').text('Database name is required.');
                    isValid = false;
                }

                if (db_username === '') {
                    $('#database_username_error').text('Database username is required.');
                    isValid = false;
                }

                if (isValid) {
                    loading(true);
                    $.ajax({
                        url: "{{ route('install.database_setup.store') }}",
                        method: "POST",
                        data: {
                            _token: $('meta[name="csrf_token"]').attr('content'),
                            database_host: db_host,
                            database_port: db_port,
                            database_name: db_name,
                            database_username: db_username,
                            database_password: db_password
                        },
                        success: function (response) {
                            loading(false);
                            Toast.fire({
                                icon: 'success',
                                title: 'Database Setup completed successfully!'
                            }).then(() => {
                                window.location.href = "{{ route('install.admin_setup') }}";
                            });
                        },
                        error: function (xhr) {
                            loading(false);
                            if (xhr.responseJSON.errors) {
                                let errors = xhr.responseJSON.errors;
                                if (errors.database_host) {
                                    $('#database_host_error').text(errors.database_host[0]);
                                }
                                if (errors.database_port) {
                                    $('#database_port_error').text(errors.database_port[0]);
                                }
                                if (errors.database_name) {
                                    $('#database_name_error').text(errors.database_name[0]);
                                }
                                if (errors.database_username) {
                                    $('#database_username_error').text(errors.database_username[0]);
                                }
                                if (errors.database_password) {
                                    $('#database_password_error').text(errors.database_password[0]);
                                }
                            }

                            Toast.fire({
                                icon: 'error',
                                title: xhr.responseJSON.message
                            })
                        }
                    });
                }
            });
        });
    </script>
@endpush
