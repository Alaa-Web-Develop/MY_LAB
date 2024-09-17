@extends('layouts.mainLayout')
@section('title', 'Daily Requests')

@section('content')

    <!-- Main content -->

    <div class="col">
        <div class="card p-3">

            <!-- /.card-header -->
            <div class="card-body">
                @if ($transferRequests->isEmpty())
                    <p>No transfer requests available.</p>
                @else
                    <table id="example1" class="table table-bordered table-striped text-center">
                        <thead style="background-color: rgba(255, 255, 0, 0.375);">
                            <tr>
                                <th>Doctor Name</th>

                                <th>Requested Points</th>
                                <th>Request Status</th>
                                <th>Transfer Type</th>
                                <th>Transfer Phone Number</th>
                                <th>Money</th>
                                <th>Request Date</th>

                                <th>Status</th>

                            </tr>
                        </thead>
                       

                        <tbody>
                            @foreach ($transferRequests as $request)
                                <tr id="request-row-{{ $request['id'] }}">
                                    <td style="font-weight: 800">{{ $request['doctor_name'] }}</td>
                                    <td style="font-weight: 800">{{ $request['points'] }}</td>
                                    <td style="font-weight: 800" id="status-{{ $request['id'] }}">{{ $request['status'] }}
                                    </td>
                                    <td style="font-weight: 800">{{ $request['transfer_type'] }}</td>
                                    <td style="font-weight: 800">{{ $request['transfer_phone_number'] }}</td>
                                    <td style="font-weight: 800">{{ $request['money'] }}</td>
                                    <td style="font-weight: 800">{{ $request['created_at'] }}</td>



                                   
                                        <td>
                                            <form id="statusForm-{{$request['id']}}" action="{{ route('dashboard.updateTransferStatus') }}" method="POST" onsubmit="showLoadingAlert()"">
                                                @csrf
                                                <input type="hidden" name="request_id" value="{{ $request['id'] }}">
                                                <input type="hidden" name="doctor_id" value="{{ $request['doctor_id'] }}">
                                                {{-- <select name="status" class="form-control" onchange="this.form.submit()"> --}}
                                                    <select name="status" class="form-control" onchange="handlestatusChange(this)">
                                                    <option value="pending" {{ $request['status'] == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="approved" {{ $request['status'] == 'approved' ? 'selected' : '' }}>Approved</option>
                                                    <option value="rejected" {{ $request['status'] == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                </select>

                                                <textarea name="rejection_reason" id="rejection_reason-{{$request['id']}}" class="form-control mt-2" placeholder="enter rejection reason..!" style="display: none;" cols="30" rows="10"></textarea>
                                                <button type="submit" class="btn btn-primary mt-2 btn-sm">Update Status</button>
                                            </form>
                                        </td>

                                   
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



                            </tr>

                        </tfoot>

                    </table>

                    @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>



@endsection

@push('scripts')
<script>
    function handlestatusChange (select) { 
         // Extract the request ID from the select element's name (in this case, it's attached to the form or select element)
         const requestId = select.closest('form').querySelector('input[name="request_id"]').value;
    const reasonField = document.getElementById(`rejection_reason-${requestId}`);
        
        if(select.value === 'rejected'){
            reasonField.style.display ='block';
            reasonField.setAttribute('required','required');
        }else{
            reasonField.style.display ='none';
            reasonField.removeAttribute('required','required');

        }
     }

     function showLoadingAlert() {
        // Show loading alert
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
    }

</script>
    
@endpush

{{-- @push('scripts')
    <script>
        $(document).ready(function() {
            //$('#example1').DataTable();

    //         var table = $('#example1').DataTable();
    
    // if (table.data().count() === 0) {
    //     table.clear().draw();
    //     $('#example1').append('<p>No transfer requests available.</p>');
    // }


            $('.change-status').on('change', function() {
                const requestId = $(this).data('request-id');
                const doctorId = $(this).data('doctor-id');
                const newStatus = $(this).val();

               
                $.ajax({
                    url: '{{ route('dashboard.updateTransferStatus') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        request_id: requestId,
                        status: newStatus,
                        doctor_id: doctorId
                    },
                    success: function(response) {
                        
                        if (response.success) {
                            $('#status-' + requestId).text(newStatus.charAt(0).toUpperCase() +
                                newStatus.slice(1));
                            alert('Status updated and doctor notified!');
                        } else {
                            alert('Failed to update status!');
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred while processing your request.');
                    }
                });
            });
        });
    </script>
@endpush --}}

