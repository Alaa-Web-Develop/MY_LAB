@extends('layouts.mainLayout')
@section('title', 'Sponsored Requests')





@section('content')

    <!-- Main content -->

    <div class="col-8 offset-2">
        <div class="card">

            <!-- /.card-header -->
            <div class="card-body">

                @if ($sponsoredRequests->isempty())
                    <p>No sponsored test requests at the moment.</p>
                @else
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Doctor Name</th>
                                <th>Patient Name</th>
                                <th>Test Name</th>
                                <th>Sponsor Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sponsoredRequests as $sponsorReq)
                                <tr>
                                    <td>{{ $sponsorReq->doctor->name }}</td>
                                    <td>{{ $sponsorReq->patient->firstname }}</td>
                                    <td>{{ $sponsorReq->labOrder->test->name }}</td>
                                    {{-- <td>{{ $sponsorReq->sponsor->name }}</td> --}}
                                     <!-- Check if the sponsor exists before accessing the name -->
        <td>{{ $sponsorReq->sponsor ? $sponsorReq->sponsor->name : 'No Sponsor' }}</td>
        <td>{{ ucfirst($sponsorReq->status) }}</td>
                                    <td>Actions</td>

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
                    @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>


@endsection
