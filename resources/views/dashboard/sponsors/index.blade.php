@extends('layouts.mainLayout')
@section('title', 'Sponsors')





@section('content')

    <!-- Main content -->

    <div class="col-8 offset-2">
        <div class="card">
            <div class="card-header">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ModalAdd"><i
                        class="bi bi-plus-square-dotted"></i>
                    Create New Sponsor</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Logo</th>
                            <th>Create At</th>
                            <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sponsors as $sponsor)
                            <tr>
                                <td>{{ $sponsor->name }}</td>
                                <td>
                                <img src="{{asset($sponsor->logo)}}" style="width: 70px;" alt="logo">    
                                </td>                           
                                <td>{{ date('d/m/Y H:i A', strtotime($sponsor->created_at)) }}</td>
                                <td>
                                    <div class="d-flex">
                                        <div>
                                          
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateSponsorModal{{ $sponsor->id }}" style="margin-right: 5px;">
                                                Edit
                                            </button>
                                        </div>
                                        <div>
                                            <form action="{{ route('dashboard.sponsors.destroy', $sponsor->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-outline-danger btn-sm show_confirm"><i
                                                        class="bi bi-trash"></i> Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                   
                                   
                                    <!-- Update Courier Modal =======-->
<div class="modal fade" id="updateSponsorModal{{ $sponsor->id }}" tabindex="-1" aria-labelledby="updateCourierModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateCourierModalLabel">Update Sponsor: {{ $sponsor->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('dashboard.sponsors.update', $sponsor->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <!-- Courier Name -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $sponsor->name }}" required>
                    </div>

                    <!-- Courier Phone -->
                    <div class="form-group">
                        <label for="logo">Logo</label>
                        <input type="file" accept="image/*" name="logo" class="form-control" value="{{ $sponsor->phone }}" required>
                    </div>

             
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Sponsor</button>
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
                    <h5 class="modal-title" id="exampleModalLabe3">Add Sponsor</h5>
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


                <form class="form-horizontal" action="{{ route('dashboard.sponsors.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row" style="align-items: baseline;margin-bottom:10px">
                            <div class="col-3">
                                <label for="">Sponsor Name</label>
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" name="name" placeholder="enter sponsor name">
                            </div>
                        </div>


                        <div class="form-row" style="align-items: baseline;margin-bottom:10px">
                            <div class="col-3">
                                <label for="">Logo</label>
                            </div>
                            <div class="col-9">
                                <input type="file" accept="image/*" class="form-control" name="logo" placeholder="enter sponsor logo ">
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
