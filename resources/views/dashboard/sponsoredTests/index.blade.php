@extends('layouts.mainLayout')
@section('title', 'Sponsored Tests')





@section('content')

    <!-- Main content -->

    <div class="col-8 offset-2">
        <div class="card">
       
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Test</th>
                            <th>Lab</th>
                            <th>Sponor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sponsoredTests as $sponsor)
                            <tr>
                                <td>{{ $sponsor->test->name }}</td>
                                <td>{{ $sponsor->lab->name }}</td>
                                <td>{{ $sponsor->sponsor->name }}</td>

                            </tr>
                        @empty
              
                        @endforelse

                    </tbody>
                    <tfoot>
                        <tr>
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
