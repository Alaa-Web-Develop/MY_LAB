<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Patient History : {{ $patient->full_name }}</title>
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <style>

    </style>
</head>

<body>
    <div class="container mt-4">
        <p>Tracking : {{ $patient->tracking_number }}</p>
        <div class="row" style="justify-content: space-between;border: 1px solid #00000038;padding: 13px;">
            <div class="form-group">
                <label style="text-align: end;">patient name</label>
                <div>
                    <input type="text" class="form-control" value="{{ $patient->full_name }}" readonly>
                </div>
            </div>
            <div class="form-group ">
                <label style="text-align: end;">patient phone</label>
                <div>
                    <input type="text" class="form-control" value="{{ $patient->phone }}" readonly>
                </div>
            </div>
            <div class="form-group ">
                <label style="text-align: end;">patient age</label>
                <div>
                    <input type="text" class="form-control" value="{{ $patient->age }}" readonly>
                </div>
            </div>
        </div>

        <div class="table-responsive mt-2">
            <table class="table">
                <thead style="background-color: rgba(222, 184, 135, 0.366)">
                    <tr>
                        <th>Date</th>
                        <th>Diagnose</th>
                        <th>Doctor</th>
                        <th>Test</th>
                        <th>Lab</th>
                        <th>Branch</th>
                        <th>Branch Address</th>
                        <th>Branch Phone</th>
                        <th>Expected Result Date</th>
                        <th>Result released Date</th>
                        <th>result</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($history as $item)
                        <tr>
                            <td>{{$item['labOrder_date']?date('Y-m-d H:i',strtotime($item['labOrder_date'])):'' }}</td>
                            <td>{{ $item['diagnose_name'] }}</td>
                            <td>{{ $item['doctor_name'] }}</td>
                            <td>{{ $item['test_name'] }}</td>
                            <td>{{ $item['lab_name'] }}</td>
                            <td>{{ $item['branch_name'] }}</td>
                            <td>{{ $item['branch_address'] }}</td>
                            <td>{{ $item['branch_phone'] }}</td>
                            <td>{{$item['expected_result_at']?date('Y-m-d H:i',strtotime( $item['expected_result_at'])):'' }}</td>
                            <td>{{$item['result_released_at']?date('Y-m-d H:i',strtotime( $item['result_released_at'])):'' }}</td>
                            <td>
                                @if ($item['result'])
                                <a href="{{ route('download-patient-history-result', $item['labOrder_id']) }}"
                                    class="btn btn-primary"><i class="bi bi-cloud-arrow-down"></i></a>
                                    @else
                                        No result yet
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>



    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
