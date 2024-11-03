@extends('layouts.mainLayout')
@section('title', 'Sponsored Requests')





@section('content')

<!-- Filter Section -->
{{-- <div class="row mb-3 p-3 justify-content-center" style="background-color: rgba(255, 255, 0, 0.67)"> --}}
    <div class="p-3 mb-3 col-10 offset-1" style="background-color: rgb(136 255 0 / 67%);">
        <form action="{{ route('dashboard.doctors-sponsored-requests.index') }}" method="GET">
            <div class="row">
                <!-- Sponsor Name Filter (Dropdown) -->
                <div class="col-md-4">
                    <label for="">Sponsor Name</label>
                    <select name="sponsor_name" class="form-control">
                        <option value="">Select Sponsor</option>
                        @foreach ($sponsors as $sponsor)
                            <option value="{{$sponsor->name}}" {{ request('sponsor_name') == $sponsor->name ? 'selected' : '' }}>
                                {{ $sponsor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Range Filter -->
                <div class="col-md-3">
                    <label for="">From</label>
                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}" placeholder="From Date">
                </div>

                <div class="col-md-3">
                    <label for="">To</label>

                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}" placeholder="To Date">
                </div>

                <!-- Filter Button -->
                <div class="col-md-2" style="top: 30px;">
                
                    {{-- <label for=""></label> --}}
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
    </div>
{{-- </div> --}}

    <!-- Main content -->

    <div class="col-10 offset-1">
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
                                <th>Request Date</th>
                                {{-- <th>Status</th> --}}
                                {{-- <th>Actions</th> --}}
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
        <td>{{ $sponsorReq->created_at}}</td>

        {{-- <td>{{ ucfirst($sponsorReq->status) }}</td> --}}
                                    {{-- <td>Actions</td> --}}

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
                                {{-- <th></th> --}}


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
