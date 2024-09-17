@extends('layouts.mainLayout')
@section('title', 'Specialities')





@section('content')

    <!-- Main content -->

    <div class="col-8 offset-2">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('dashboard.specialities.create') }}" class="btn btn-primary"><i class="bi bi-plus-square-dotted"></i>
                Create New Speciality</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Created at</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($specs as $spec)
                            <tr>
                                <td>{{ $spec->name }}</td>
                                <td class="font-bold text-{{ $spec->status == 'active' ? 'success' : 'danger' }}"">
                                    {{ $spec->status }}</td>
                                <td>{{ date('d/m/Y H:i A', strtotime($spec->created_at)) }}</td>
                                <td><a href="{{ route('dashboard.specialities.edit', $spec->id) }}" class="btn btn-outline-primary btn-sm"><i
                                            class="bi bi-pencil-square "></i> Edit</a></td>
                                <td>
                                    <form action="{{ route('dashboard.specialities.destroy', $spec->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit"  class="btn btn-outline-danger btn-sm show_confirm"><i class="bi bi-trash"></i> Delete</button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            {{-- <tr>
                      <td colspan="5">No Specialities Found..!</td>
                      
                  </tr> --}}
                        @endforelse

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Created_at</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>

                    </tfoot>

                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

@endsection
