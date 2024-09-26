@extends('dashboard.layouts.main')

@push('title')
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
    @can('superadmin-only')
        <div class="row">
            <div class="col-xl-4">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-primary-subtle text-primary rounded-2 fs-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-briefcase text-primary">
                                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2">
                                        </rect>
                                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                    </svg>
                                </span>
                            </div>
                            <div class="flex-grow-1 overflow-hidden ms-3">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Active Projects</p>
                                <div class="d-flex align-items-center mb-3">
                                    <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="825">825</span>
                                    </h4>
                                    <span class="badge bg-danger-subtle text-danger fs-12"><i
                                            class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span>
                                </div>
                                <p class="text-muted text-truncate mb-0">Projects this month</p>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div>
            </div><!-- end col -->

            <div class="col-xl-4">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-warning-subtle text-warning rounded-2 fs-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-award text-warning">
                                        <circle cx="12" cy="8" r="7"></circle>
                                        <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                                    </svg>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-uppercase fw-medium text-muted mb-3">New Leads</p>
                                <div class="d-flex align-items-center mb-3">
                                    <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                            data-target="7522">7,522</span></h4>
                                    <span class="badge bg-success-subtle text-success fs-12"><i
                                            class="ri-arrow-up-s-line fs-13 align-middle me-1"></i>3.58 %</span>
                                </div>
                                <p class="text-muted mb-0">Leads this month</p>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div>
            </div><!-- end col -->

            <div class="col-xl-4">
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
                                        <span class="counter-value" data-target="40">40</span>m</h4>
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
