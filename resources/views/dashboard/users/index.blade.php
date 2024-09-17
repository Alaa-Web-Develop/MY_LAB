@extends('layouts.mainLayout')
@section('title', 'Users ')


@section('content')

    <!-- Main content -->

    <div class="col">
        <div class="card">
            <div class="card-header">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#UserAdd"><i
                        class="bi bi-plus-square-dotted mx-1"></i> Create New User</a>

            </div>



            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created at</th>
                            <th>Edit</th>
                            <th>Delete</th>

                        </tr>
                    </thead>
                    <tbody>



                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="font-bold text-{{ $user->type == 'admin' ? 'primary' : 'black' }}"">
                                    {{ $user->type }}</td>
                                <td>{{ date('d/m/Y H:i A', strtotime($user->created_at)) }}</td>

                                <td>
                                    <a href="#" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                        data-target="#UserEdit{{$user->id}}"><i class="bi bi-pencil-square "></i> Edit</a>
                                </td>
                                <td>
                                    <form id="myform" action="{{route('dashboard.users.destroy',$user->id)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button form="myform" type="submit" class="btn btn-outline-danger btn-sm show_confirm">
                                            <i class="bi bi-trash"></i> Delete</button>
                                                
                                    </form>

                                </td>
                            </tr>

                            @include('dashboard.users.modalEdit',$user)
                           

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
    <div class="modal fade" id="UserAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
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


                <form class="form-horizontal" action="{{route('dashboard.users.store') }}" method="post">
                    @csrf

                    <div class="modal-body">
                        <div class="form-row" style="align-items: baseline;margin-bottom:10px">
                            <div class="col-3">
                                <label for="">User Name</label>
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" name="name" placeholder="enter user name">
                            </div>
                        </div>

                        <div class="form-row" style="align-items: baseline;margin-bottom:10px">
                            <div class="col-3">
                                <label for="">User Email</label>
                            </div>
                            <div class="col-9">
                                <input type="email" class="form-control" name="email" placeholder="enter user email">
                            </div>
                        </div>

                        <div class="form-row" style="align-items: baseline;margin-bottom:10px">
                            <div class="col-3">
                                <label for="">User Password</label>
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" name="password" placeholder="enter user password">
                            </div>
                        </div>



                        <div class="form-row" style="align-items: baseline;margin-bottom:10px">
                            <div class="col-3">
                                <label for="">User Role</label>
                            </div>
                            <div class="col-9">
                                <select name="type" class="form-control">
                                    <option value="admin">Admin</option>
                                    {{-- <option value="lab">Lab</option>
                                    <option value="doctor">Doctor</option> --}}

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

@push('scripts')
    <script type="text/javascript">
        @if (count($errors) > 0)
            $('#UserAdd').modal('show');
        @endif
    </script>
@endpush
