<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>Dashboard | Velzon - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('be/assets/images/favicon.ico') }}">
    <!--Swiper slider css-->
    <link href="{{ asset('be/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Layout config Js -->
    <script src="{{ asset('be/assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('be/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('be/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('be/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('be/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('be/assets/css/datatables/datatables.css') }}" rel="stylesheet" type="text/css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('dashboard.layouts.partials.navbar')
        <!-- removeNotificationModal -->
        <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="NotificationModalbtn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mt-2 text-center">
                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                            <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                <h4>Are you sure ?</h4>
                                <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                            <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete
                                It!</button>
                        </div>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

        @include('dashboard.layouts.partials.sidebar')
        <div class="vertical-overlay"></div>
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @include('dashboard.layouts.partials.breadcrumb')
                    @yield('content')
                    @include('dashboard.layouts.partials.footer')
                    <!-- End Page-content -->
                </div>
            </div>
        </div>
    </div>

    @include('dashboard.layouts.partials.back-to-top')
    @include('dashboard.layouts.partials.preloader')
    @include('dashboard.layouts.partials.setting')

    <!-- JAVASCRIPT -->
    <script src="{{ asset('be/assets/js/jquery.js') }}"></script>
    <script src="{{ asset('be/assets/js/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('be/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('be/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('be/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('be/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('be/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('be/assets/js/plugins.js') }}"></script>
    <script src="{{ asset('be/assets/libs/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('be/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>
    <script src="{{ asset('be/assets/js/app.js') }}"></script>


    <script>
        $(document).ready(function() {
            $('#table').DataTable({

            });
        });
    </script>

</body>


</html>
