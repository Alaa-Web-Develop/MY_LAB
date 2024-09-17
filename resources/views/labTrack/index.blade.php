<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Branch - Dashboard</title>

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
            <a class="navbar-brand" href="#">Lab Branch {{ $branch->name }}</a>
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
                <h5>Branch Name: {{ $branch->name }}</h5>
                <p>Location: {{ $branch->location }}</p>
                <p>Contact: {{ $branch->phone }}</p>
                <p>City: {{ $branch->city->city_name_ar }}</p>
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
                                    <th>Doctor Name</th>
                                    <th>Patient Name</th>
                                    <th>Patient Discount Points</th>
                                    <th>Test Name</th>
                                    <th>Test Price</th>

                                    <th>Expected Delivery Date</th>
                                    <th>Status</th>
                                    <th>Delivered At</th>
                                    <th>Result Files</th>
                                    <th>Notes</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($labOrders as $labOrder)
                                    <tr>
                                        <td>{{ $labOrder->id }}</td>
                                        <td>{{ $labOrder->doctor ? $labOrder->doctor->name : '' }}</td>
                                        <td>{{ $labOrder->patient ? $labOrder->patient->full_name : '' }}</td>
                                        <td>{{ $labOrder->labTest ? $labOrder->labTest->discount_points : '' }}</td>

                                        <td>{{ $labOrder->test ? $labOrder->test->name : '' }}</td>
                                        <td>{{ $labOrder->labTest ? $labOrder->labTest->price : '' }}</td>
                                        <td>{{ $labOrder->labTrack ? $labOrder->labTrack->expected_delivery_date : '' }}
                                        </td>
                                        <td>{{ $labOrder->labTrack ? ucfirst($labOrder->labTrack->status) : '' }}</td>
                                        <td>{{ $labOrder->labTrack ? $labOrder->labTrack->delivered_at : '' }}</td>

                                        <td>
                                            @if ($labOrder->labTrack && $labOrder->labTrack->result)
                                                <a href="{{ route('labTrack.download-lab-docs', $labOrder->id) }}"
                                                    class="btn btn-primary"><i class="bi bi-cloud-arrow-down"></i></a>
                                            @else
                                                No files uploaded
                                            @endif
                                        </td>
                                        <td>{{ $labOrder->labTrack ? $labOrder->labTrack->notes : '' }}</td>


                                        <td>
                                            <!-- Link to trigger modal -->
                                            <a href="{{ route('labTrack.edit-laborder-track', $labOrder->id) }}"
                                                class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#updateLabOrderModal{{ $labOrder->id }}">Update</a>
                                        </td>

                                        <div class="modal fade" id="updateLabOrderModal{{ $labOrder->id }}"
                                            tabindex="-1" role="dialog"
                                            aria-labelledby="updateLabOrderModalLabel{{ $labOrder->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document"
                                                style="max-width: 50%; max-height:80%; overflow-y:hidden;">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="updateLabOrderModalLabel{{ $labOrder->id }}">Update Lab
                                                            Order</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form
                                                            action="{{ route('labTrack.update-laborder-track', $labOrder->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="form-row" style="margin-bottom: 2%">
                                                                <div class="form-group offset-2 col-md-3">
                                                                    <label for="expected_delivery_date">Expected
                                                                        Delivery Date</label>
                                                                    <input type="datetime-local"
                                                                        id="expected_delivery_date"
                                                                        name="expected_delivery_date"
                                                                        class="form-control"
                                                                        value="{{ $labOrder->labTrack ? $labOrder->labTrack->expected_delivery_date : '' }}">
                                                                </div>
                                                                <div class="form-group col-md-3">
                                                                    <label for="status">Status</label>
                                                                    <select name="status" id="status"
                                                                        class="form-control">
                                                                        <option value="pending"
                                                                            {{ $labOrder->labTrack && $labOrder->labTrack->status === 'pending' ? 'selected' : '' }}>
                                                                            Pending</option>
                                                                        <option value="delivered"
                                                                            {{ $labOrder->labTrack && $labOrder->labTrack->status === 'delivered' ? 'selected' : '' }}>
                                                                            Delivered</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-3">
                                                                    <label for="delivered_at">Delivered At</label>
                                                                    <input type="datetime-local" id="delivered_at"
                                                                        name="delivered_at" class="form-control"
                                                                        value="{{ $labOrder->labTrack ? $labOrder->labTrack->delivered_at : '' }}">
                                                                </div>
                                                            </div>

                                                            <div class="form-row" style="margin-bottom: 2%">
                                                                <div class="form-group offset-2 col-md-6">
                                                                    <label for="results">Upload Results</label>
                                                                    <input type="file" name="results[]"
                                                                        id="results" class="form-control" multiple>
                                                                </div>
                                                            </div>

                                                            <div class="form-row" style="margin-bottom: 2%">
                                                                <div class="form-group offset-2 col-md-6">
                                                                    <label for="notes">Notes</label>
                                                                    <textarea id="notes" name="notes" class="form-control">{{ $labOrder->labTrack ? $labOrder->labTrack->notes : '' }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="form-row">
                                                                <div class="offset-2 col-3">
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Update Lab
                                                                        Order</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

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
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
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
