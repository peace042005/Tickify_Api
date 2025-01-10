<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title Meta -->
    <meta charset="utf-8" />
    <title>Dashboard | Darkone - Dark Admin & UI Kit Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="robots" content="index, follow" />
    <meta name="theme-color" content="#ffffff">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Google Font Family link -->
    @include('frontend.css')
</head>

<body>

    <!-- START Wrapper -->
    <div class="app-wrapper">

        <!-- Topbar Start -->
        @include('frontend.top')
        <!-- Topbar End -->

        <!-- App Menu Start -->
        @include('frontend.side')
        <!-- App Menu End -->

        <!-- ==================================================== -->
        <!-- Start right Content here -->
        <!-- ==================================================== -->
        <div class="page-content">

            <div class="container-fluid">
                <!-- Start Container Fluid -->
                @yield('content')
                <!-- End Container Fluid -->

                <!-- Footer Start -->
                @include('frontend.footer')
                <!-- Footer End -->

            </div>

        </div>
    </div>
    <!-- END Wrapper -->
    @include('frontend.js')

</body>

</html>
