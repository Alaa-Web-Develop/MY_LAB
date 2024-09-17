@extends('layouts.mainLayout')
@section('title', 'Lab_Branches| Profiles')

@section('content')

    <!-- Main content -->

    <div class="col">
        <div class="card">
            {{-- <div class="card-header">
                <a href="{{ route('dashboard.lab_branches.create') }}" class="btn btn-primary"><i class="bi bi-plus-square-dotted"></i>
                    create lab_Branche profile</a>
            </div> --}}
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>Branch Name</th>
                            <th>Main Lab</th>
                            <th>Governorate</th>
                            <th>City</th>
                            <th>location</th>
                            <th>phone</th>
                            <th>hotline</th>
                            <th>Email</th>
                            <th>User Login</th>
                            <th>Approval Status</th>
                            <th>description</th>

                            <th>Created_at</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>



                        @forelse ($labBranches as $lab)
                            <tr>
                                <td>{{ $lab->name }}</td>
                                <td>{{ $lab->lab_name }}</td>
                                <td>{{ $lab->govern_name }}</td>
                                <td>{{ $lab->city_name }}</td>
                                <td>{{ $lab->location }}</td>
                                <td>{{ $lab->phone }}</td>
                                <td>{{ $lab->hotline }}</td>
                                <td>{{ $lab->email }}</td>
                                <td>{{ $lab->user->name }}</td>
                                <td
                                    class="font-bold text-{{ $lab->Approval_Status == 'approved' ? 'success' : 'danger' }}"">
                                    {{ $lab->Approval_Status }}</td>
                                <td>{{ $lab->description }}</td>

                                <td>{{ date('d/m/Y H:i A', strtotime($lab->created_at)) }}</td>



                                <td><a href="{{ route('dashboard.lab_branches.edit', $lab->id) }}" class="btn btn-outline-primary btn-sm"><i
                                            class="bi bi-pencil-square "></i> Edit</a></td>
                                <td>
                                    <form action="{{ route('dashboard.lab_branches.destroy', $lab->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit"  class="btn btn-outline-danger btn-sm show_confirm"><i class="bi bi-trash"></i>
                                            Delete</button>
                                    </form>

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

@endsection
