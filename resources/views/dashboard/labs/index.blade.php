@extends('layouts.mainLayout')
@section('title', 'Labs')

@section('content')

    <!-- Main content -->

    <div class="col" style="width: 90%;">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('dashboard.labs.create') }}" class="btn btn-primary"><i class="bi bi-plus-square-dotted"></i>
                    Create New Lab</a>

                {{-- <a href="{{ route('dashboard.lab_branches.index') }}" class="btn btn-success"><i
                        class="bi bi-plus-square-dotted"></i>
                    Display All Branches</a> --}}

                {{-- <a href="{{ route('dashboard.lab_barnch_test.index') }}" class="btn btn-success"><i
                        class="bi bi-plus-square-dotted"></i> Tests Info</a> --}}


            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            {{-- Lab Name
Hotline
Branches ( View – Add New )
Tests ( View – Add New )
Status
Actions ( View - Edit ) --}}


                            <th>Lab Name</th>
                            <th>Hotline</th>
                            <th>Branches</th>
                            <th>Tests</th>
                            <th>Status</th>
                            <th>Actions</th>


                            {{-- <th>logo</th>
                            <th>Governorate</th>
                            <th>City</th>
                            <th>Address</th>
                          <th>Location</th>
                            <th>Phone</th>                         
                            <th>Email</th>
                            <th>Add Branch</th>
                            <th>Available Tests</th>
                            <th>description</th>
                            <th>Created_at</th>
                            <th>Edit</th>
                            <th>Delete</th> --}}
                        </tr>
                    </thead>
                    <tbody>



                        @forelse ($labs as $lab)
                            <tr>
                                <td>{{ $lab->name }}</td>
                                <td>{{ $lab->hotline }}</td>

                                <td>
                                    <div class="d-flex" style="justify-content: space-evenly;">

                                        <div>
                                            <a href="#" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                            data-target="#ModalShowBranches{{ $lab->id }}">
                                            {{-- <i class="bi bi-pencil-square "></i> --}}
                                            Show Branches
                                        </a>
                                        </div>

                                        <div>
                                            <a href="#" class="btn btn-outline-success btn-sm" style="color: black;" data-toggle="modal"
                                            data-target="#ModalAddBranches{{ $lab->id }}">
                                            <i class="bi bi-plus-square-dotted"></i>
    
                                            Add Branche </a>
                                        </div>

                                    </div>
                                    
                                </td>

                                <td>
                                    <div class="d-flex" style="justify-content: space-evenly;">
                                        <div>
                                            <a href="{{ route('dashboard.labs.test.info', $lab->id) }}"
                                                class="btn btn-outline-primary btn-sm view-tests-btn"
                                                data-lab-id="{{ $lab->id }}" data-lab-name="{{ $lab->name }}">
                                                Show Tests
                                            </a>
                                        </div>
                                        <div>
                                            <a href="#" class="btn btn-outline-success btn-sm" style="color: black;" data-toggle="modal"
                                            data-target="#ModalAssignTestInfo{{ $lab->id }}"><i
                                                class="bi bi-plus-square-dotted"></i>
                                            Add Test</a>
                                        </div>
                                    </div>
                                   
                                </td>

                                <td
                                    class="font-bold text-{{ $lab->Approval_Status == 'approved' ? 'success' : 'danger' }}"">
                                    {{ $lab->Approval_Status }}
                                </td>

                                <td>
                                    <div class="d-flex" style="justify-content: space-evenly;">
                                        <div>
                                            <a href="{{ route('dashboard.labs.edit', $lab->id) }}"
                                                class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil-square "></i> Edit</a>
                                        </div>
                                        <div>
                                            <form action="{{ route('dashboard.labs.destroy', $lab->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-outline-danger btn-sm show_confirm"><i
                                                        class="bi bi-trash"></i>
                                                    Delete</button>
                                            </form>
                                        </div>

                                        <div>
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#MoreLab{{$lab->id }}">More</a>
                                        </div>
                                    </div>
                                </td>

                                {{-- <td><img src="{{ asset($lab->logo) }}" alt="lab_img" class="w-50 h-50"></td> --}}
                                {{-- <td>{{ $lab->govern_name }}</td>
                                <td>{{ $lab->city_name }}</td>
                                <td>{{ $lab->address }}</td> --}}

                                {{-- <td>{{ $lab->location }}</td> --}}
                                {{-- <td>{{ $lab->phone }}</td>

                                <td>{{ $lab->email }}</td> --}}


                                
                                  
                                    {{-- 
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#labTestsModal{{ $lab->id }}">
                                        View Tests
                                    </button> --}}


                                {{-- <td>{{ $lab->description }}</td> --}}

                                {{-- <td>{{ date('d/m/Y H:i A', strtotime($lab->created_at)) }}</td> --}}

                                {{-- More Modal===================================================================================== --}}
                                <div class="modal fade" id="MoreLab{{$lab->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="MoreLab{{$lab->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document"
                                        style="max-width: 60%;overflow-y:hidden;">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="MoreLab{{$lab->id }}">
                                                    Lab:<span class="text-danger">{{ $lab->name }}</span>  Details</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-row" style="margin-bottom: 2%">
                                                    <div class="form-group col-md-4">
                                                        <label>Lab Name</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $lab->name }}" readonly>
                                                    </div>

                                                    <div class="form-group col-md-2">
                                                        <label>Status</label>
                                                        <input disabled type="text" class="form-control"
                                                            value="{{ $lab->Approval_Status }}"> 
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label>Hotline</label>
                                                        <input disabled type="text" class="form-control"
                                                        value="{{ $lab->hotline }}"> 
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label>Phone</label>
                                                        <input disabled type="text" class="form-control"
                                                        value="{{ $lab->phone }}"> 
                                                    </div>
                                               
                                                </div>




                                                <div class="form-row" style="margin-bottom: 2%">
                                                    <div class="form-group col-md-2">
                                                        <label>Governorate</label>
                                                        <input type="text" disabled 
                                                           class="form-control"
                                                            value="{{ $lab->govern_name }}">
                                                    </div>

                                                    <div class="form-group col-md-2">
                                                        <label>City</label>
                                                        <input type="text" disabled 
                                                           class="form-control"
                                                            value="{{ $lab->city_name }}">
                                                    </div>

                                                    <div class="form-group col-md-5">
                                                        <label>Address</label>
                                                        <input type="text" disabled 
                                                           class="form-control"
                                                            value="{{ $lab->address }}">
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <label>Email</label>
                                                        <input type="text" disabled 
                                                           class="form-control"
                                                            value="{{ $lab->email }}">
                                                    </div>

                                                   
                                                </div>


                                                <div class="form-row" style="margin-bottom: 2%">
                                                    <div class="form-group col-md-12">
                                                        <label>logo</label>
                                                        <img src="{{ asset($lab->logo) }}" alt="lab_img" style="height: 170px;">

                                                    </div>
                                                </div>
                                                 
                                                  
                                                <div class="form-row" style="margin-bottom: 2%">
                                                    <div class="form-group col-md-12">
                                                        <label>description</label>
                                                        <input type="text" disabled 
                                                        class="form-control"
                                                         value="{{ $lab->description }}">
                                                    </div>
                                                </div>


                                               



                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- More details==================================================================================================== --}}
                            </tr>

                            @include('dashboard.labs.showBranches', $lab)
                            @include('dashboard.labs.AddBranch', $lab)
                            @include('dashboard.labs.ModalAssignTestInfo', $lab)
                            {{-- @include('dashboard.labs.labTestsModal', $lab) --}}



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
                            {{-- <th></th>
                            <th></th>
                            <th></th>


                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th> --}}


                            {{-- <th></th>
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




<!-- Modal (Single Instance) -->
<div class="modal fade" id="labTestsModal" tabindex="-1" role="dialog" aria-labelledby="labTestsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="labTestsModalLabel">Tests for <span id="labName"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Table to display lab tests -->
                <table class="table table-bordered" id="testsTable">
                    <thead>
                        <tr>
                            <th>Test Name</th>
                            <th>Price</th>
                            <th>Points</th>
                            <th>Discount Points</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dynamic content will be inserted here -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        $(document).ready(function() {
            // Handle button click to open modal
            $('.view-tests-btn').on('click', function() {
                var labId = $(this).data('lab-id');
                var labName = $(this).data('lab-name');

                //alert(labId);
                // Set the lab name in the modal title
                $('#labName').text(labName);
                //alert(labName);
                // Fetch tests data via AJAX (or pass from server-side in the button attributes)
                $.ajax({
                    url: '/dashboard/labs/' + labId + '/tests', // Replace with your actual route
                    //alert(labId);
                    method: 'GET',
                    success: function(data) {
                        //alert(data)
                        console.log(data);
                        // Clear previous content
                        $('#testsTable tbody').empty();

                        // Populate table with test data
                        data.forEach(function(test) {
                            var row = '<tr>' +
                                '<td>' + test.name + '</td>' +
                                '<td>' + test.price + '</td>' +
                                '<td>' + test.points + '</td>' +
                                '<td>' + test.discount_points + '</td>' +
                                '<td>' + test.notes + '</td>' +
                                '</tr>';
                            $('#testsTable tbody').append(row);
                        });

                        // Show the modal
                        $('#labTestsModal').modal('show');
                    }
                });
            });
        });
    </script>
@endpush
