@extends('auth.layouts.main')

@push('title')
    Unauthorize
@endpush

@section('content')
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-5 pt-4">
                        <div class="mb-5 text-white-50">
                            <h1 class="display-5 coming-soon-text">This action is forbidden.</h1>
                            <p class="fs-14">Please check your role account</p>
                            <div class="mt-4 pt-2">
                                <a href="{{ route('dashboard') }}" class="btn btn-success"><i class="mdi mdi-home me-1"></i>
                                    Back
                                    to Dashboard</a>
                            </div>
                        </div>
                        <div class="row justify-content-center mb-5">
                            <div class="col-xl-4 col-lg-8">
                                <div>
                                    <img src="{{ asset('be/assets/images/forbidden.png') }}" alt=""
                                        class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->
@endsection
