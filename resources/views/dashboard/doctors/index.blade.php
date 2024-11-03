@extends('layouts.mainLayout')
@section('title', 'Doctors')





@section('content')

    {{-- loader======== --}}
    {{-- <div id="loader" class="d-flex justify-content-center align-items-center" style="display: none;">
    <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div> --}}
    {{-- loader======== --}}

    <!-- Main content -->

    <div class="col">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('dashboard.doctors.create') }}" class="btn btn-primary"><i
                        class="bi bi-plus-square-dotted"></i>
                    Create New Account</a>
            </div>

                     


            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped text-center">
                    <thead style="background-color: #a4fc9a71">
                        <tr>
                            <th>Created Date</th>
                            <th>Doctor Name</th>
                            <th>Institution</th>
                            <th>Speciality</th>
                            <th>Profession Docs</th>
                            <th>Status</th>
                            <th>Approval Date</th>
                            <th>Actions</th>
                            {{--                            
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Governorate</th>
                            <th>City</th>
                            <th style="background-color: #a3fc9a;">Total Points</th>
                            <th>Doctor notes</th>
                            <th>Edit</th>
                            <th>Delete</th> --}}
                        </tr>
                    </thead>
                    <tbody>



                        @forelse ($doctors as $doctor)
                            <tr>
                                <td>{{ date('d/m/Y H:i A', strtotime($doctor->created_at)) }}</td>
                                <td>{{ $doctor->name }}</td>
                                <td>{{ $doctor->inst_name }}</td>
                                <td>{{ $doctor->spec_name }}</td>
                                <td>
                                    @if ($doctor->doctorDocs->isNotEmpty())
                                        <a href="{{ route('dashboard.download-doc-docs', $doctor->id) }}"><i
                                            class="bi bi-cloud-arrow-down-fill"></i> download</a>
                                    
                                        
                                    @else
                                        No Prof.Docs
                                    @endif
                                   
                                </td>
                                {{-- <td>
                                    @if($doctor->documents->isNotEmpty()) <!-- Assuming 'documents' is a relationship -->
                                        <a href="{{ route('dashboard.download-doc-docs', $doctor->id) }}">
                                            <i class="bi bi-cloud-arrow-down-fill"></i> download
                                        </a>
                                    @else
                                        <!-- You can leave this empty, or add a message like "No documents" if you prefer -->
                                    @endif
                                </td> --}}

                                <td>
                                    <select class="form-control approval-status" data-doctor-id="{{ $doctor->id }}">
                                        <option value="pending"
                                            {{ $doctor->Approval_Status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved"
                                            {{ $doctor->Approval_Status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    </select>
                                </td>

                                <td>{{ date('d/m/Y H:i A', strtotime($doctor->updated_at)) }}</td>
                                <td>
                                    <div class="d-flex">
                                        <div style="margin-right: 2px;">
                                            <a href="{{ route('dashboard.doctors.edit', $doctor->id) }}"
                                                class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil-square "></i> Edit</a>
                                        </div>
                                        <div style="margin-right: 2px;">
                                            <form action="{{ route('dashboard.doctors.destroy', $doctor->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-outline-danger btn-sm show_confirm"><i
                                                        class="bi bi-trash"></i> Delete</button>
                                            </form>
                                        </div>
                                        <div>
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#MoreDoctor{{$doctor->id }}">More</a>
                                        </div>
                                    </div>
                                </td>




                                {{-- 
                                <td>{{ $doctor->phone }}</td>
                                <td>{{ $doctor->email }}</td>
                                <td>{{ $doctor->govern_name }}</td>
                                <td>{{ $doctor->city_name }}</td> 
                                 <td style="background-color: #a3fc9a;">{{ $doctor->total_points }}</td>
                                   <td>{{ $doctor->doctor_notes }}</td>

                                --}}

                                {{-- <td class="font-bold text-{{ $doctor->Approval_Status == 'approved' ? 'success' : 'danger' }}">
                                    {{ $doctor->Approval_Status }}
                                </td> --}}

                                {{-- Modal Details=================== --}}

                                <div class="modal fade" id="MoreDoctor{{$doctor->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="MoreDoctor{{$doctor->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document"
                                        style="max-width: 60%; max-height:70%; overflow-y:hidden;">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="MoreDoctor{{$doctor->id }}">
                                                    Doctor:<span class="text-danger">{{ $doctor->name }}</span>  Details</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-row" style="margin-bottom: 2%">
                                                    <div class="form-group col-md-4">
                                                        <label>Doctor Name</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $doctor->name }}" readonly>
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label>Institution</label>
                                                        <input disabled type="text" class="form-control"
                                                            value="{{ $doctor->inst_name }}"> 
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label>Speciality</label>
                                                        <input disabled type="text" class="form-control"
                                                        value="{{ $doctor->spec_name }}"> 
                                                    </div>
                                               
                                                </div>




                                                <div class="form-row" style="margin-bottom: 2%">
                                                    <div class="form-group col-md-3">
                                                        <label>Doctor Phone</label>
                                                        <input type="text" disabled 
                                                           class="form-control"
                                                            value="{{ $doctor->phone }}">
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <label>Doctor Email</label>
                                                        <input type="text" disabled 
                                                           class="form-control"
                                                            value="{{ $doctor->email }}">
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <label>Doctor Governorate</label>
                                                        <input type="text" disabled 
                                                           class="form-control"
                                                            value="{{ $doctor->govern_name }}">
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <label>Doctor City</label>
                                                        <input type="text" disabled 
                                                           class="form-control"
                                                            value="{{ $doctor->city_name }}">
                                                    </div>

                                                   
                                                </div>









                                                <div class="form-row" style="margin-bottom: 2%">
                                                    <div class="form-group col-md-3">
                                                        <label>Created Date</label>
                                                        <input disabled type="datetime-local" class="form-control"
                                                            value="{{$doctor->created_at}}"> 
                                                    </div>

                                                 
                                                    <div class="form-group col-md-3">
                                                        <label>Status</label>

                                                        <select class="form-control approval-status" data-doctor-id="{{ $doctor->id }}" disabled>
                                                            <option value="pending"
                                                                @selected($doctor->Approval_Status == 'pending' ? 'selected' : '' )>Pending</option>
                                                            <option value="approved"
                                                            @selected($doctor->Approval_Status == 'approved' ? 'selected' : '' )>Approved</option>
                                                        </select>

                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <label>Approval Date</label>
                                                        <input disabled type="datetime-local" class="form-control"
                                                            value="{{$doctor->updated_at}}"> 
                                                    </div>

                                                </div>



                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Modal Details=================== --}}


                            </tr>


                        @empty
                        @endforelse

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
                            {{-- <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th> --}}


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
        $(document).ready(function() {
            $('.approval-status').change(function() {
                var doctorId = $(this).data('doctor-id');
                var newStatus = $(this).val();

                //console.log(newStatus);

                $.ajax({
                    url: '{{ route('dashboard.doctor.update.status') }}', // Define the route
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Include CSRF token
                        doctor_id: doctorId,
                        Approval_Status: newStatus
                    },

                    beforeSend: function() {
                        Swal.fire({
                            title: 'Processing...',
                            text: 'Please wait while we update the status.',
                            icon: 'info',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },


                    success: function(response) {

                        Swal.fire({
                            title: 'Success!',
                            text: 'Doctor status updated successfully.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });

                        //alert('Doctor status updated successfully');
                        // Optionally update UI elements or display a success message
                    },
                    error: function(xhr) {

                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while updating the status.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });

                        // alert('An error occurred while updating the status');
                        // Handle error case
                    }
                });
            });
        });
    </script>
@endpush
