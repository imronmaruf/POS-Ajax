@extends('dashboard.layouts.main')

@push('title')
    Dashboard {{ ucfirst(Auth::user()->role ?? '') }}
@endpush

@push('css')
@endpush
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card overflow-hidden">
                <div class="card-body bg-primary d-flex">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 lh-base mb-0 text-white">Welcome to starter template <br> your own
                            <span class="text-success">NFTs.</span>
                        </h4>
                        <p class="mb-0 mt-2 pt-1 text-white">The world's first and largest digital marketplace.</p>
                        {{-- <div class="d-flex gap-3 mt-4">
                                    <a href="#!" class="btn btn-primary">Discover Now </a>
                                    <a href="#!" class="btn btn-success">Create Your Own</a>
                                </div> --}}
                    </div>

                    <img src="{{ asset('be/assets/images/bg-d.png') }}" alt="" class="img-fluid">
                </div>
            </div>
        </div><!--end col-->

    </div>
    @can('owner-only')
        <div class="row">
            <div class="col-lg-3">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-primary-subtle text-primary rounded-2 fs-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-users text-primary material-shadow">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </span>
                            </div>
                            <div class="flex-grow-1 overflow-hidden ms-3 ">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Users</p>
                                <div class="d-flex align-items-center mb-3">
                                    <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                            data-target="{{ $userCount }}">0</span>
                                    </h4>
                                    {{-- <span class="badge bg-danger-subtle text-danger fs-12"><i
                                            class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> --}}
                                </div>

                            </div>
                        </div>
                    </div><!-- end card body -->
                </div>
            </div><!-- end col -->

            <div class="col-lg-3">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-warning-subtle text-warning rounded-2 fs-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-shopping-bag text-warning">
                                        <path d="M6 2l.01 6H18V2H6z"></path>
                                        <path d="M18 6l3 12H3L6 6"></path>
                                        <path d="M10 10V4a4 4 0 1 1 8 0v6"></path>
                                    </svg>
                                </span>
                            </div>

                            <div class="flex-grow-1 overflow-hidden ms-3 ">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Store</p>
                                <div class="d-flex align-items-center mb-3">
                                    <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                            data-target="{{ $storeCount }}">0</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->

            <div class="col-lg-3">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-info-subtle text-info rounded-2 fs-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-clock text-info">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                </span>
                            </div>
                            <div class="flex-grow-1 overflow-hidden ms-3">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Total Hours</p>
                                <div class="d-flex align-items-center mb-3">
                                    <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="168">168</span>h
                                        <span class="counter-value" data-target="40">40</span>m
                                    </h4>
                                    <span class="badge bg-danger-subtle text-danger fs-12"><i
                                            class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>10.35 %</span>
                                </div>
                                <p class="text-muted text-truncate mb-0">Work this month</p>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div>
            </div><!-- end col -->
        </div>
    @endcan
@endsection
