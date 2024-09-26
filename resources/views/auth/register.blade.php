@extends('auth.layouts.main')

@section('content')
    <!-- auth page content -->
    <div class="auth-page-content">
        <div class="container">
            {{-- <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-5 mb-4 text-white-50">
                        <div>
                            <h1 class="text-center text-white text-uppercase"> Starter Template</h1>

                            <a href="index.html" class="d-inline-block auth-logo">
                                <img src="assets/images/logo-light.png" alt="" height="20">
                            </a>
                        </div>
                        <p class="mt-2 fs-15 fw-medium">Laravel 11 &amp; Laravel UI</p>
                    </div>
                </div>
            </div> --}}
            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4 card-bg-fill">

                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Create New Account</h5>
                                <p class="text-muted">Get your free Starter Template account now</p>
                            </div>
                            <div class="p-2 mt-4">
                                <form method="POST" class="needs-validation" novalidate=""
                                    action="{{ route('register') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="name" class="form-label">{{ __('Name') }}<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" placeholder="Enter name" required="" name="name">
                                        @error('name')
                                            <div class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label ">Email
                                            <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}"
                                            placeholder="Enter email address" required="" autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="password-input">Password</label>
                                        <div class="position-relative auth-pass-inputgroup">
                                            <input type="password"
                                                class="form-control pe-5 password-input @error('password') is-invalid @enderror"
                                                onpaste="return false" placeholder="Enter password" id="password-input"
                                                name="password" aria-describedby="passwordInput"
                                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required=""
                                                autocomplete="new-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <span
                                                class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none"
                                                type="button" id="password-addon"><i
                                                    class="ri-eye-fill align-middle me-3"></i></span>

                                            {{-- <div class="invalid-feedback">
                                                Please enter password
                                            </div> --}}
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="password-confirm">{{ __('Confirm Password') }}</label>
                                        <div class="position-relative auth-pass-inputgroup">
                                            <input type="password"
                                                class="form-control pe-5 password-confirm @error('password') is-invalid @enderror"
                                                onpaste="return false" placeholder="Enter password" id="password-confirm"
                                                name="password_confirmation" aria-describedby="passwordInput"
                                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required=""
                                                autocomplete="new-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror


                                        </div>
                                    </div>

                                    {{-- <div class="mb-4">
                                        <p class="mb-0 fs-12 text-muted fst-italic">By registering you agree to the Velzon
                                            <a href="#"
                                                class="text-primary text-decoration-underline fst-normal fw-medium">Terms of
                                                Use</a>
                                        </p>
                                    </div> --}}

                                    <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                        <h5 class="fs-13">Password must contain:</h5>
                                        <p id="pass-length" class="invalid fs-12 mb-2">Minimum <b>8 characters</b></p>
                                        <p id="pass-lower" class="invalid fs-12 mb-2">At <b>lowercase</b> letter (a-z)</p>
                                        <p id="pass-upper" class="invalid fs-12 mb-2">At least <b>uppercase</b> letter
                                            (A-Z)
                                        </p>
                                        <p id="pass-number" class="invalid fs-12 mb-0">A least <b>number</b> (0-9)</p>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-success w-100" type="submit">{{ __('Register') }}</button>
                                    </div>

                                    <div class="mt-4 text-center">
                                        <div class="signin-other-title">
                                            <h5 class="fs-13 mb-4 title text-muted">Create account with</h5>
                                        </div>

                                        <div>
                                            <button type="button"
                                                class="btn btn-primary btn-icon waves-effect waves-light"><i
                                                    class="ri-facebook-fill fs-16"></i></button>
                                            <button type="button"
                                                class="btn btn-danger btn-icon waves-effect waves-light"><i
                                                    class="ri-google-fill fs-16"></i></button>
                                            <button type="button"
                                                class="btn btn-dark btn-icon waves-effect waves-light"><i
                                                    class="ri-github-fill fs-16"></i></button>
                                            <button type="button"
                                                class="btn btn-info btn-icon waves-effect waves-light"><i
                                                    class="ri-twitter-fill fs-16"></i></button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                    <div class="mt-4 text-center">
                        <p class="mb-0">Already have an account ? <a href="{{ route('login') }}"
                                class="fw-semibold text-primary text-decoration-underline"> Login </a> </p>
                    </div>

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->
@endsection

@push('js')
    <script src="{{ asset('be/assets/js/pages/passowrd-create.init.js') }}"></script>
    {{-- <script src="{{ asset('be/assets/js/pages/form-validation.init.js') }}"></script> --}}
@endpush
