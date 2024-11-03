@extends('layouts.mainLayout')
@section('title', 'Patients')

@section('content')

    <!-- Main content -->

    <div class="col">
        <div class="card">

            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>firstname</th>
                            {{-- <th>lastname</th> --}}
                            <th>doctor</th>
                            {{-- <th>diagnose</th> --}}
                            <th>Pathology Report Image</th>
                            <th>Required Tests</th>
                            <th>phone</th>
                            <th>Email</th>
                            <th>Age</th>
                            <th>Comment</th>
                            <th>Created at</th>
                        </tr>
                    </thead>
                    <tbody>



                        @forelse ($patients as $patient)
                            <tr>
                                <td>{{ $patient->firstname }}</td>
                                {{-- <td>{{ $patient->lastname }}</td> --}}
                                <td>{{ $patient->doctor_name }}</td>
                                {{-- <td>{{ $patient->diagnose_name }}</td> --}}

                                <td>
                                    {{-- <a href="{{route('dashboard.download-patient-docs',$patient->id)}}"><i class="bi bi-cloud-arrow-down-fill" style="font-size: 22px"></i></a> --}}

                                    <button class="btn" onclick="downloadPatientReport({{$patient->id}})">
                                        <i class="bi bi-cloud-arrow-down-fill" style="font-size: 22px"></i>
                                    </button>

                                </td>
                              

                                <td><a href="#" style="color:rgb(32, 0, 128);" data-toggle="modal" data-target="#RequiredTest{{$patient->id}}"><i class="bi bi-calendar2" style="font-size: 22px"></i></a></td>
                                             

                                <td>{{ $patient->phone }}</td>
                                <td>{{ $patient->email }}</td>
                                <td>{{ $patient->age }}</td>
                                <td>{{ $patient->comment }}</td>

                                <td>{{ date('d/m/Y H:i A', strtotime($patient->created_at)) }}</td>
                            </tr>


                            @include('dashboard.patients.requiredTests', $patient)

                        @empty
                        @endforelse

                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            {{-- <th></th> --}}
                            <th></th>
                            {{-- <th></th> --}}
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

@endsection
@push('scripts')
<script> 
//'patient-download/{id}'
function downloadPatientReport(patientId) {
    fetch(`/dashboard/patient-download/${patientId}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => {
        // Check for file download response by inspecting content type
        const contentType = response.headers.get("content-type");
        
        if (contentType && contentType.includes("application/json")) {
            // Handle JSON response (e.g., error)
            return response.json().then(data => {
                if (!data.success) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.message,
                    });
                }
            });
        } else {
            // File download response (not JSON), trigger download
            window.location.href = `/dashboard/patient-download/${patientId}`;
        }
    });
    
}

</script>
    
@endpush