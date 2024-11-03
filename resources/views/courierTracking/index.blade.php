<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier Tracking</title>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('dist/img/logo.png') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

    <link rel="stylesheet" href="{{ asset('dist/css/myOwnStyle.css') }}">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    {{-- bootstrap-icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

    @stack('styles')

    <!-- Custom CSS -->
    <style>
        .navbar-brand,
        .nav-link {
            color: white !important;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .table thead th {
            background-color: #343a40;
            color: white;
        }

        .logout-btn {
            background-color: #dc3545;
            color: white;
        }

        .branch-info {
            background-color: #6c757d;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-info bg-info">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Courier {{$courier->name }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn logout-btn">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Branch Info -->
    <div class="container-fluid mt-4">
        <div class="offset-3 col-6">
            <div class="branch-info">
                <h5>Courier Name: {{ $courier->name }}</h5>
                <p>Email: {{ $courier->email }}</p>
                <p>Phone: {{ $courier->phone }}</p>
                {{-- <p>City: {{ $branch->city->city_name_ar }}</p> --}}
            </div>
        </div>


        <!-- Data Table -->
        <div class="table-responsive">

            <div class="col">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped text-center">
                            <thead style="background-color: rgba(255, 187, 0, 0.563)">
                                <tr>
			
                                    <th>Order ID</th>
                                    <th>Patient Name</th>
                                    <th>Lab Name</th>
                                    <th>Branch Name</th>
                                    <th>Branch Address</th>
                                    <th>Branch Number</th>
                                    <th>Courier Name</th>
                                    <th>Status</th>
                                    <th>Collected Date</th>
                                    <th>Action</th>
   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $orders as $order )
                                @php
                                $labOrder=$order->labOrder;
                                @endphp
                                   <tr>
                                    <td>{{ $labOrder->id }}</td>
                                    <td>{{ $labOrder->patient->firstname }}</td>
                                    <td>{{ $labOrder->lab->name }}</td>
                                    <td>{{ $labOrder->labBranch->name }}</td>
                                    <td>{{ $labOrder->labBranch->address }}</td>
                                    <td>{{ $labOrder->labBranch->phone}}</td>
                                    <td>{{ $order->courier->name }}</td>
                                    <td><span class="p-1 badge-{{ $order->status == 'new'?'primary':'success' }}">{{ $order->status }}</span></td>
                                    <td>
                                        {{ $order->collected_at ? $order->collected_at->format('Y-m-d H:i:s') : '' }}
                                    </td>

                                    <td>
                                        <!-- Example Action Button -->
                                        <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModalCenter{{$order->id}}">Update Status</a>
                                        <!-- Add more actions as needed -->
                                    </td>

                                    {{-- Modal Update Status --}}

  <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('dashboard.courierTracking.update',$order->id)}}" method="post">
            @csrf
            @method('PUT')
       
        <div class="modal-body">
            {{-- {{$order->id}} --}}
            <div class="form-row">
                <div class="form-group col-4">
                    <label for="">Status</label>
                    <select name="status" id="" class="form-control">
                        <option value="new">New</option>
                        <option value="collected">Collected</option>
                    </select>
                </div>

                <div class="form-group col-6">
                    <label for="">Collected At</label>
                   <input type="datetime-local" name="collected_at" class="form-control">
                </div>

            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
      </div>
    </div>
  </div>
                                    {{-- Modal Update Status end --}}

                                   </tr>
                                @endforeach
                         
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>

                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                  

                                </tr>

                            </tfoot>

                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>


        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- SweetAlert2 -->

    <!-- Toastr -->


    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist/js/demo.js') }}"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

    {{-- sweetalert ====================== --}}
    <script src="{{ asset('dist/js/sweetalert.min.js') }}"></script>
    <script type="text/javascript">
        $('.show_confirm').click(function(event) {
            var form = $(this).closest("form");

            //   var name = $(this).data("name");
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

    @stack('scripts')
</body>

</html>
