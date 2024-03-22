<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kapella Bootstrap Admin Dashboard Template</title>
    <!-- base:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/base/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />

    <link rel="stylesheet" href="{{ asset('assets/css/pelajaran.css') }}">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/js/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/js/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/js/datatables-buttons/css/buttons.bootstrap4.min.css') }}" />
</head>

<body>
    @if (session('success'))
        <link rel="stylesheet" href="{{ asset('assets/js/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}" />

        <script src="{{ asset('assets/js/sweetalert2/sweetalert2.min.js') }}"></script>
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
            });

            Toast.fire({
                icon: "success",
                title: "{{ session('success') }}",
            });
        </script>
    @endif

    @if (session('error'))
        <link rel="stylesheet" href="{{ asset('assets/js/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}" />

        <script src="{{ asset('assets/js/sweetalert2/sweetalert2.min.js') }}"></script>
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
            });

            Toast.fire({
                icon: "error",
                title: "{{ session('error') }}",
            });
        </script>
    @endif
    <div class="container-scroller">
        @php
            $role = auth()->user()->role;
        @endphp
        @if ($role === 'admin')
            @include('partials.navbar_admin')
        @elseif ($role === 'guru')
            @include('partials.navbar_guru')
        @elseif ($role === 'siswa')
            @include('partials.navbar_siswa')
        @endif

        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
            </div>
        </div>
        @include('partials.footer')

    </div>
    <!-- container-scroller -->
    <!-- base:js -->
    <script src="{{ asset('assets/vendors/base/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <!-- endinject -->

    <!-- plugin js for this page -->
    <!-- End plugin js for this page -->
    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/chartjs-plugin-datalabels/chartjs-plugin-datalabels.js') }}"></script>
    <script src="{{ asset('assets/vendors/justgage/raphael-2.1.4.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/justgage/justgage.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <!-- Custom js for this page-->
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <!-- End custom js for this page-->

    <!-- DataTables  & Plugins -->
    <script src="{{ asset('assets/js/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/js/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/js/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/js/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables-buttons/js/buttons.colVis.min.js') }}"></script>


    <script>
        $(function() {
            $("#table1")
                .DataTable({
                    responsive: true,
                    lengthChange: false,
                    autoWidth: false,
                    buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
                })
                .buttons()
                .container()
                .appendTo("#table1_wrapper .col-md-6:eq(0)");
            $("#table2").DataTable({
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: true,
                responsive: true,
            });
        });
    </script>
</body>

</html>
