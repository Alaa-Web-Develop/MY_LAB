@extends('layouts.mainLayout')
@section('title', 'Couriers Lab Orders')

@section('content')

    <!-- Main content -->

    <div class="col">
        <div class="card">

            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead style="background-color: rgba(255, 166, 0, 0.445)">
                        <tr>
                            <th>Lab Order Date</th>
                            <th>Lab Order Number</th> <!-- Example column for Lab Order details -->
                            <th>Patient Name</th>
                            <th>Lab Name</th>
                            <th>Branch Name</th>
                            <th>Branch Address</th>
                            <th>Branch Number</th>
                            <th>Courier</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($couriersLabOrders as $test)
                            <tr>
                                <td>{{ $test->labOrder->created_at }}
                                    <td>{{ $test->labOrder->id ?? '' }}</td>
                                <td>{{ $test->labOrder->patient->firstname ?? '' }}
                                    {{ $test->labOrder->patient->lastname ?? '' }}</td>
                                <td>{{ $test->labOrder->lab->name ?? '' }}</td>
                                <td>{{ $test->labOrder->labBranch->name ?? '' }}</td>
                                <td>{{ $test->labOrder->labBranch->address ?? '' }}</td>
                                <td>{{ $test->labOrder->labBranch->phone ?? '' }}</td>
                                <td>
                                    {{-- {{ $test->courier->name ?? '' }} --}}
                                <form action="{{route('dashboard.couriercollectedtests.update',$test->id)}}" method="post">
                                    @csrf
                                    @method('PUT')
                                  
                                            <select name="courier_id" class="form-control" onchange="this.form.submit()">
                                                <option value="">Select Courier</option>
                                                @foreach ($couriers as $courier )
                                                    <option value="{{$courier->id}}" {{$test->courier_id  == $courier->id ? 'selected':''}}>{{$courier->name}}</option>
                                                @endforeach
                                            </select>
                                    

                                </form>

                                </td>
                              

                                <td><span class="p-2 badge-primary">{{ $test->status}}</span></td>
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
