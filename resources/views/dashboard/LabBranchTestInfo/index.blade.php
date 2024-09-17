@extends('layouts.mainLayout')
@section('title', 'Test Info ')


@section('content')

    <!-- Main content -->

    <div class="col">
        <div class="card">
            <div class="card-header">
                {{-- <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ModalAdd"><i
                        class="bi bi-plus-square-dotted mx-1"></i> Create Test</a> --}}

            </div>

            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>Test Id</th>
                            <th>Test Name</th>
                            <th>1% Discount For</th>
                            <th>Test Price</th>
                            <th>Available Labs</th>
                            <th>Doctor Point</th>
                            <th>Notes</th>
                            <th>Created at</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>



                        @forelse ( $tests_info as $test)
                            <tr>
                                <td>{{ $test->test_id }}</td>
                                <td>{{ $test->test_name }}</td>
                                <td>{{ $test->discount_points }}</td>
                                <td>{{ $test->test_price }}</td>
                                <td>{{ $test->lab_name }}</td>
                                <td>{{ $test->doctor_points }}</td>
                                <td>{{ $test->notes }}</td>
                                <td>{{ date('d/m/Y H:i A', strtotime($test->created_at)) }}</td>

                                <td>
                                    <a href="#" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                        data-target="#ModalTestInfoEdit{{ $test->test_id }}"><i class="bi bi-pencil-square "></i>
                                        Edit</a>
                                </td>
                                <td>
                                    <form id="myform" action="{{route('dashboard.tests.branches.destroy',['test_id' => $test->test_id, 'branch_id' => $test->lab_id]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button form="myform" type="submit"
                                            class="btn btn-outline-danger btn-sm show_confirm">
                                            <i class="bi bi-trash"></i> Delete</button>

                                    </form>

                                </td>
                            </tr>

                            @include('dashboard.LabBranchTestInfo.modalEdit', $test)

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



                        </tr>

                    </tfoot>

                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    {{-- ============================== Modal Add============================ --}}

 
    {{-- ============================== Modal Add============================ --}}

@endsection

@push('scripts')
    <script type="text/javascript">
        @if (count($errors) > 0)
            $('#ModalTestInfoEdit').modal('show');
        @endif
    </script>
@endpush




