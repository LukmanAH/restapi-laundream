<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transactions</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet"
        href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet"
        href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">

    <link rel="icon" href="{{ asset('asset/image/logo.png') }}" type="image/x-icon">
</head>

<body>
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('asset/image/logo.png') }}"
                alt="AdminLTELogo" height="60" width="60">
        </div>

        {{-- @include('partials.navbar')

        @include('partials.sidebar') --}}

        <!-- Content Wrapper. Contains page content -->
        <div>
            

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi</h6>
                                </div>
                                <div class="card-body">
                                    @if(session('status'))
                                        <div class="alert alert-success mt-3">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    <div class="table">
                                        <table class="table table-bordered" id="example1" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Serial</th> 
                                                    <th>Nama Layanan</th>
                                                    <th>Service Tipe</th>   
                                                    <th>Customer</th>                                                  
                                                    <th>Parfume</th>
                                                    <th>Total Harga</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($transactions as $transaction)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $transaction->serial }}</td>
                                                            <td>{{ $transaction->catalog->name }}</td>
                                                            <td>{{ $transaction->service_type }}</td>  
                                                            <td>{{ $transaction->user->name }}</td>                                                          
                                                            <td>{{ $transaction->parfume->name }}</td>
                                                            <td>{{ $transaction->amount }}</td>
                                                         
                                                        </tr>
                                                @empty($transactions)
                                                    <tr>
                                                        <td colspan="6">Tidak ada data laporan</td>
                                                    </tr>
                                                @endempty
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer>
            <strong>Copyright &copy; 2022 <a href="#">Laundream</a>.</strong>
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)

    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script
        src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
    </script>
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}">
    </script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist/js/demo.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('js/table/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/table/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/table/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/table/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/table/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/table/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/table/jszip.min.js') }}"></script>
    <script src="{{ asset('js/table/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/table/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/table/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/table/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/table/buttons.colVis.min.js') }}"></script>
    <script>
    $(function () {
        $("#example1").DataTable({
            "responsive": false,
            "lengthChange": true,
            "autoWidth": false,
            "buttons": [
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5', 
            ]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

</script>
</body>

</html>

