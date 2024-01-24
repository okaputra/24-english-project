<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>24 English Center Admin</title>
    <!-- Favicon icon -->
    {{-- <link rel="icon" type="image/png" sizes="16x16" href="{{asset('admin//images/favicon.png')}}"> --}}
    <link rel="stylesheet" href="{{asset('admin/vendor/owl-carousel/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/vendor/owl-carousel/css/owl.theme.default.min.css')}}">
    <link href="{{asset('admin/vendor/jqvmap/css/jqvmap.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('admin/vendor/jquery-steps/css/jquery.steps.css')}}" rel="stylesheet">

    <!-- Datatable -->
    <link href="{{asset('admin/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    @include('layout.script')

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        @yield('header')

        @yield('sidebar')

        @yield('body')


        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="#" target="_blank">Oka Putra</a></p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{asset('admin/vendor/global/global.min.js')}}"></script>
    <script src="{{asset('admin/js/quixnav-init.js')}}"></script>
    <script src="{{asset('admin/js/custom.min.js')}}"></script>

    <script src="{{asset('admin/vendor/jquery-steps/build/jquery.steps.min.js')}}"></script>
    <script src="{{asset('admin/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <!-- Form validate init -->
    <script src="{{asset('admin/js/plugins-init/jquery.validate-init.js')}}"></script>



    <!-- Form step init -->
    <script src="{{asset('admin/js/plugins-init/jquery-steps-init.js')}}"></script>

    <!-- Vectormap -->
    <script src="{{asset('admin/vendor/raphael/raphael.min.js')}}"></script>
    <script src="{{asset('admin/vendor/morris/morris.min.js')}}"></script>


    <script src="{{asset('admin/vendor/circle-progress/circle-progress.min.js')}}"></script>
    <script src="{{asset('admin/vendor/chart.js/Chart.bundle.min.js')}}"></script>

    <script src="{{asset('admin/vendor/gaugeJS/dist/gauge.min.js')}}"></script>

    <!--  flot-chart js -->
    <script src="{{asset('admin/vendor/flot/jquery.flot.js')}}"></script>
    <script src="{{asset('admin/vendor/flot/jquery.flot.resize.js')}}"></script>

    <!-- Owl Carousel -->
    <script src="{{asset('admin/vendor/owl-carousel/js/owl.carousel.min.js')}}"></script>

    <!-- Counter Up -->
    <script src="{{asset('admin/vendor/jqvmap/js/jquery.vmap.min.js')}}"></script>
    <script src="{{asset('admin/vendor/jqvmap/js/jquery.vmap.usa.js')}}"></script>
    <script src="{{asset('admin/vendor/jquery.counterup/jquery.counterup.min.js')}}"></script>

    <!-- Datatable -->
    <script src="{{asset('admin/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('admin/js/plugins-init/datatables.init.js')}}"></script>

    <script src="{{asset('admin//js/dashboard/dashboard-1.js')}}"></script>

</body>

</html>