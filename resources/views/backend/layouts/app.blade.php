<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Admin Panel | {{$info->company_name}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="{{$info->company_name}}" name="description" />
        <meta content="{{$info->company_name}}" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="/logo2.jpeg">

        <!-- Select2 CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
        <!-- slick css -->
        <link href="/backend/assets/libs/slick-slider/slick/slick.css" rel="stylesheet" type="text/css" />
        <link href="/backend/assets/libs/slick-slider/slick/slick-theme.css" rel="stylesheet" type="text/css" />

        <!-- jvectormap -->
        <link href="/backend/assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />

        <!-- Bootstrap Css -->
        <link href="/backend/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="/backend/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="/backend/assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="/toastr.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <style>
            body{
                font-family: "Poppins", sans-serif !important;
                background: #fff!important;
            }
            #sidebar-menu ul li a{
                font-weight: 500;
            }
            .page-title-box h4{
                font-weight: 600;
            }
            @media only screen and (min-width: 991px){
                .table-responsive{
                    overflow-x: hidden;                   
                }
            }
            .page-content {
                padding: calc(70px + 24px) calc(120px / 2) 60px calc(120px / 2);
            }
            .select2{
                width: 100%!important;
            }
            .card {
                background-color: #f4f4f45e;
            }
            .tox-statusbar__branding{
                display: none;
            }
            #sidebar-menu ul li a {
                padding: 0.45rem 1rem;
            }
            .menu-title {
                font-size: 13px;
                color: #ddd !important;
            }
            .mm-active .active {
                color: #ffffff !important;
                background: #000000;
                /* border-radius: 20px; */
            }
        </style>

    </head>

    <body data-sidebar="dark">
        <!-- Begin page -->
        <div id="layout-wrapper">
          @include('backend.layouts.header')
          @include('backend.layouts.sidebar')
          <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
          </div>
          @include('backend.layouts.footer')
        </div>
        <!-- END layout-wrapper -->
        
        <!-- JAVASCRIPT -->
        <script src="/backend/assets/libs/jquery/jquery.min.js"></script>
        <script src="/backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/backend/assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="/backend/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="/backend/assets/libs/node-waves/waves.min.js"></script>
        <!--tinymce js-->
        <script src="/backend/assets/libs/tinymce/tinymce.min.js"></script>
        <!-- init js -->
        <script src="/backend/assets/js/pages/form-editor.init.js"></script>
        <!-- apexcharts -->
        <script src="/backend/assets/libs/apexcharts/apexcharts.min.js"></script>
        <script src="/backend/assets/libs/slick-slider/slick/slick.min.js"></script>
        <!-- Jq vector map -->
        <script src="/backend/assets/libs/jqvmap/jquery.vmap.min.js"></script>
        <script src="/backend/assets/libs/jqvmap/maps/jquery.vmap.usa.js"></script>
        <script src="/backend/assets/js/pages/dashboard.init.js"></script>
        <script src="/backend/assets/js/app.js"></script>
        <!-- validation init -->
        <script src="/backend/assets/js/pages/form-validation.init.js"></script>
        <script src="/backend/assets/js/pages/table-responsive.init.js"></script>
        {{-- Toaster --}}
        <script src="/toastr.min.js"></script>
        <script>
            @if (Session::has('message'))
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                }
                toastr.success("{{ session('message') }}");
            @endif
            @if (Session::has('error'))
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                }
                toastr.error("{{ session('error') }}");
            @endif
            @if (Session::has('info'))
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                }
                toastr.info("{{ session('info') }}");
            @endif
            @if (Session::has('warning'))
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                }
                toastr.warning("{{ session('warning') }}");
            @endif
        </script>
        {{-- Delete Button --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
        <script type="text/javascript">
            $('.delete-confirm').click(function(event) {
                var form = $(this).closest("form");
                var name = $(this).data("name");
                event.preventDefault();
                swal({
                        title: `Are you sure you want to delete this record?`,
                        text: "If you delete this, it will be gone forever.",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        }
                    });
            });
        </script>
        <script>
            function printableContent(printableContent) {
                var printContents = document.getElementById(printableContent).innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
            }
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <script>
            // Initialize Select2
            $(document).ready(function() {
            $('.select2').select2();
            });
        </script>
        @yield('script')
        <script>
            tinymce.init({
              selector: '.editor',
            });
        </script>
    </body>
</html>
