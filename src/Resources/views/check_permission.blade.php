@extends('laravelInstaller::layout.master')
@section('page_title', 'Check Permissions')
@section('menu_title', 'Check Permissions')
@section('content')
    <div class="mt-3">
        <h3 class="mb-4">Check Folders Permission</h3>
        <div class="row">
            @php $failed = 0 @endphp
            @foreach($requirements ?? [] as $req)
                <div class="col-lg-6 mb-3">
                    <div class="bg-white p-3 rounded-3 shadow-sm  d-flex justify-content-between align-items-center ">
                        <h6>{{ $req['title'] }}</h6>
                        <span>
                        @if ($req['value'] == true)
                                <i class="bi bi-check-circle-fill text-success"></i> YES
                            @else
                                @php $failed += 1 @endphp
                                <i class="bi bi-ban-fill text-danger"></i> NO
                            @endif
                    </span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="hero-buttons mt-4 text-center">
            <a href="javascript:" id="goNext" class="btn btn-primary me-0 me-sm-2 mx-1">
                Go to Next <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('#goNext').click(function () {
                @if($failed < 1)
                Toast.fire({
                    icon: 'success',
                    title: 'Checking forlders permissions completed successfully!'
                }).then(() => {
                    window.location.href = "{{ route('install.license_verification') }}";
                });
                @else
                Toast.fire({
                    icon: 'error',
                    title: 'Please fulfill the requirements'
                })
                @endif
            })
        })
    </script>
@endpush
