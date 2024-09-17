@extends('layouts.mainLayout')
@section('title', 'Couriers')





@section('content')

    <!-- Main content -->

    <div class="col-8 offset-2">
        <div class="card">
            <div class="card-header">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ModalAdd"><i
                        class="bi bi-plus-square-dotted"></i>
                    Create New Courier</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Area Of Activity</th>
                            <th>Email</th>
                            <th>Create At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @forelse ($couriers as $courier)
                            <tr>
                                <td>{{ $courier->name }}</td>
                                <td>{{ $courier->phone }}</td>
                                <td>
@if ($courier->areas->isNotEmpty())
{{ $courier->areas->pluck('area')->implode(', ') }}
@else
No areas assigned
@endif
                                </td>
                                <td>{{ $courier->email }}</td>

                           
                                <td>{{ date('d/m/Y H:i A', strtotime($courier->created_at)) }}</td>
                                <td>
                                    <div class="d-flex">
                                  

                                        <div>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateCourierModal{{ $courier->id }}" style="margin-right: 5px;">
                                                Edit
                                            </button>
                                        </div>
                                    

                                        <div>
                                            <form action="{{ route('dashboard.couriers.destroy', $courier->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm show_confirm">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                   
                                   
                                    <!-- Update Courier Modal =======-->
 <!-- Edit Courier Modal -->
 <div class="modal fade" id="updateCourierModal{{ $courier->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 40%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Courier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('dashboard.couriers.update', $courier->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-row mb-3">
                        <label for="name" class="col-3">Courier Name</label>
                        <div class="col-9">
                            <input type="text" class="form-control" name="name" value="{{ $courier->name }}" required>
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <label for="phone" class="col-3">Phone Number</label>
                        <div class="col-9">
                            <input type="text" class="form-control" name="phone" value="{{ $courier->phone }}" required>
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <label for="email" class="col-3">Email</label>
                        <div class="col-9">
                            <input type="email" class="form-control" name="email" value="{{ $courier->email }}" required>
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <label for="areas" class="col-3">Areas of Activity</label>
                        <div class="col-9">
                            <select name="areas[]" class="form-control" multiple required>
                                @foreach ($govrs as $gov)
                                    <option value="{{ $gov->governorate_name_ar }}" {{ in_array($gov->governorate_name_ar, $courier->areas->pluck('area')->toArray()) ? 'selected' : '' }}>
                                        {{ $gov->governorate_name_ar }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>  
{{-- Modal update======================================== --}}
                                </td>
                               
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

                        </tr>

                    </tfoot>

                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>


       {{-- ============================== Modal Add============================ --}}

    <!-- Modal -->
    <div class="modal fade" id="ModalAdd" tabindex="-1" aria-labelledby="exampleModalLabe3" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 40%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabe3">Add Courier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- Errors======================== --}}
                @if ($errors->any())
                    <div class="text-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {{-- Errors======================== --}}


                <form class="form-horizontal" action="{{ route('dashboard.couriers.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row" style="align-items: baseline;margin-bottom:10px">
                            <div class="col-3">
                                <label for="">Courier Name</label>
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" name="name" placeholder="enter courier name">
                            </div>
                        </div>


                        <div class="form-row" style="align-items: baseline;margin-bottom:10px">
                            <div class="col-3">
                                <label for="">Phone Number</label>
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" name="phone" placeholder="enter courier phone ">
                            </div>
                        </div>

                        <div class="form-row" style="align-items: baseline;margin-bottom:10px">
                            <div class="col-3">
                                <label for="">Email</label>
                            </div>
                            <div class="col-9">
                                <input type="email" class="form-control" name="email" placeholder="enter courier email ">
                            </div>
                        </div>

                        <div class="form-row" style="align-items: baseline;margin-bottom:10px">
                            <div class="col-3">
                                <label for="">Area of Activity</label>
                            </div>
                            <div class="col-9">
                               <select name="areas[]" class="form-control" multiple required>
                                @foreach ( $govrs as $gov )
                                <option value="{{$gov->governorate_name_ar}}">{{$gov->governorate_name_ar}}</option>   
                                @endforeach
                               </select>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ============================== Modal Add============================ --}}

@endsection
