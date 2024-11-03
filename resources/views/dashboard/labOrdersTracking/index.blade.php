@extends('layouts.mainLayout')
@section('title', 'Patient Test Tracking')

@section('content')

    <!-- Main content -->

    <div class="col">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped text-center">
                    <thead style="background-color: rgba(255, 187, 0, 0.563)">
                        <tr>
                            <th>Lab Order Number</th> <!-- Example column for Lab Order details -->
                            <th>Prescription Date</th>
                            <th>Lab Received Date</th>
                           <th>Branch Name</th>
                            <th>Result</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($labOrders as $order)
                            @php
                                // Access related models
                                $labTrack = $order->labTrack;
                                $collectedTest = $order->courierCollectedTest;
                                $questions_answers = $order->testQuestions;

                                // Data extraction with default values
                                $patientName = $order->patient->full_name ?? '';
                                $doctorName = $order->doctor->name ?? '';
                                $testName = $order->test->name ?? '';
                                $testTOT=$order->labTest->test_tot??'';
                                $labBranchName = $order->labBranch->name ?? '';
                                $branchAddress = $order->labBranch->address ?? '';
                                $branchNumber = $order->labBranch->phone ?? '';

                                $collectedDate =
                                    $collectedTest && $collectedTest->collected_at
                                        ? $collectedTest->collected_at->format('Y-m-d H:i:s')
                                        : '';
                                $courierName =
                                    $collectedTest && $collectedTest->courier ? $collectedTest->courier->name : '';
                                $resultReleasedDate =
                                    $labTrack && $labTrack->result_released_at
                                        ? $labTrack->result_released_at->format('Y-m-d H:i:s')
                                        : '';
                                $result = $labTrack ? json_encode($labTrack->result) : 'N/A'; // Assuming results is an array
                                $status = $labTrack->status ?? ''; // Assuming 'status' field exists in LabOrder
                            @endphp
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                <!-- Assuming 'created_at' is used for prescription date -->
                        
                                <td>{{ $labTrack && $labTrack->lab_received_at ? $labTrack->lab_received_at->format('Y-m-d') : '' }}
                                </td>
                                <td>{{ $labBranchName }}</td>                           
                                <td>
                                    @if ($order->labTrack && $order->labTrack->result)
                                        <a href="{{ route('dashboard.download-lab-docs', $order->id) }}"
                                            class="btn btn-primary"><i class="bi bi-cloud-arrow-down"></i></a>
                                    @else
                                        No files uploaded
                                    @endif
                                </td>
                                <td>{{ $status }}</td>

                                <td>

                                    <!-- Link to trigger modal -->
                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#updateLabOrderModal{{ $order->id }}">Track</a>

                                    {{-- <a href="#" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#MoreLabOrderModal{{ $order->id }}">More</a> --}}

                                </td>

                                {{-- Modal Update --}}
                                <div class="modal fade" id="updateLabOrderModal{{ $order->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="updateLabOrderModalLabel{{ $order->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document"
                                        style="max-width: 70%; max-height:100%; overflow-y:hidden;">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="d-flex modal-title p-1">
                                                    <div class="mr-3">
                                                        <p>Track Lab Order # <span
                                                                class="text-danger">{{ $order->id }}</span></p>
                                                
                                                    </div>
                                                    <div class="mr-3">
                                                        <p>Branch Name: <span
                                                                class="text-danger">{{ $labBranchName }}</span></p>
                                                    </div>
                                                    <div class="mr-3">
                                                        <p>Branch Address: <span
                                                                class="text-danger">{{ $branchAddress }}</span></p>
                                                    </div>
                                                    <div class="mr-3">
                                                        <p>Branch Phone Number: <span
                                                                class="text-danger">{{ $branchNumber }}</span></p>
                                                    </div>
                                                </div>
                           
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">

                                                <div>
                                                    @if ($questions_answers->isEmpty())
                                                        <p>No questions and answers available for this lab order.</p>
                                                    @else
                                                        <span class="p-1 bg-warning">Medical Data :</span>
                                                        <ul style="list-style:none">
                                                            @foreach ($questions_answers as $qa)
                                                                <li>Question : {{ $qa->question }}</li>
                                                                <li>Choice : {{ $qa->answer }}</li>
                                                                <span>---------------------------------</span>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-3">
                                                        <label for="">Patient Name</label>
                                                        <input type="text" class="form-control" disabled
                                                            value="{{ $patientName }}">
                                                    </div>

                                                    <div class="form-group col-3">
                                                        <label for="">Doctor Name</label>
                                                        <input type="text" class="form-control" disabled
                                                            value="{{ $doctorName }}">
                                                    </div>


                                                    <div class="form-group col-3">
                                                        <label for="">Test</label>
                                                        <input type="text" class="form-control" disabled
                                                            value="{{ $testName }}">
                                                    </div>

                                                    <div class="form-group col-1">
                                                        <label for="">Test TOT</label>
                                                        <input type="text" class="form-control" disabled
                                                            value="{{ $testTOT }}">
                                                            <span>Days</span>
                                                    </div>

                                                </div>

                                                <hr>
                                                <div class="form-row">
                                                    <div class="form-group col-3">
                                                        <label for="">Courier Name</label>
                                                        <input type="text" class="form-control" disabled
                                                            value="{{ $courierName }}">
                                                    </div>
                                                    <div class="form-group col-3">
                                                        <label for="">Courier Date</label>
                                                        <input type="text" class="form-control" disabled
                                                            value="{{ $collectedDate }}">
                                                    </div>
                                                </div>

                                                <hr>

                                                <form action="{{ route('dashboard.track-lab_orders.update', $order->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="courier_collected_test_id"
                                                        value="{{ $collectedTest->courier_id ?? '' }}">
                                                    <div class="form-row" style="margin-bottom: 2%">

                                                        <div class="form-group col-md-3">
                                                            <label for="delivered_at">lab_received_at</label>
                                                            <input type="datetime-local" id="delivered_at"
                                                                name="lab_received_at" class="form-control"
                                                                value="{{ $order->labTrack ? $order->labTrack->lab_received_at : '' }}">
                                                        </div>


                                                        <div class="form-group col-md-3">
                                                            <label for="status">Status</label>
                                                            <select name="status" id="status" class="form-control">
                                                                <option value="ordered"
                                                                    {{ $order->labTrack && $order->labTrack->status === 'ordered' ? 'selected' : '' }}>
                                                                    ordered</option>
                                                                <option value="collected_by_courier"
                                                                    {{ $order->labTrack && $order->labTrack->status === 'collected_by_courier' ? 'selected' : '' }}>
                                                                    collected_by_courier</option>

                                                                <option value="lab_received_at"
                                                                    {{ $order->labTrack && $order->labTrack->status === 'lab_received_at' ? 'selected' : '' }}>
                                                                    received By lab</option>

                                                            </select>
                                                        </div>
                                                       {{-- @php
     // Calculate expected delivery date if lab_received_at is set
//     $expectedDeliveryDate = null;
//     if ($order->labTrack && $order->labTrack->lab_received_at) {
//         $labReceivedDate = $order->labTrack->lab_received_at; // Assuming this is a Carbon instance
//         $expectedDeliveryDate = $labReceivedDate->copy()->addDays($testTOT)->format('Y-m-d\TH:i'); // Format for datetime-local input
//     }
// @endphp

// <div class="form-group col-md-3">
//     <label for="expected_delivery_date">Expected Result Date</label>
//     <input type="datetime-local" id="expected_delivery_date" name="expected_delivery_date" class="form-control"
//         value="{{ $expectedDeliveryDate }}">
// </div> --}}
@php
 $expectedDeliveryDate = null;

    if ($order->labTrack && $order->labTrack->lab_received_at) {
        $labReceived=$order->labTrack->lab_received_at;
        $expectedDeliveryDate=$labReceived->copy()->addDays($testTOT)->format('Y-m-d\TH:i');
    }
@endphp
                                                        <div class="form-group col-md-3">
                                                            <label for="expected_delivery_date">Expected Result
                                                                Date</label>
                                                            {{-- <input type="datetime-local" id="expected_delivery_date"
                                                                name="expected_delivery_date" class="form-control"
                                                                value="{{ $order->labTrack ? $order->labTrack->expected_result_released_date : '' }}"> --}}
                                                                <input type="datetime-local" id="expected_delivery_date"
                                                                name="expected_delivery_date" class="form-control bg-info"
                                                                value="{{ $expectedDeliveryDate}}">
                                                        </div>

                                                       



                                                        <div class="form-group col-md-3">
                                                            <label for="result_released_at">Result Released Date</label>
                                                            <input type="datetime-local" id="result_released_at"
                                                                name="result_released_at" class="form-control"
                                                                value="{{ $order->labTrack ? $order->labTrack->result_released_at : '' }}">
                                                        </div>

                                                    </div>

                                                    <div class="form-row" style="margin-bottom: 2%">
                                                        <div class="form-group offset-2 col-md-6">
                                                            <label for="results">Upload Results</label>
                                                            <input type="file" name="results[]" id="results"
                                                                class="form-control" multiple>
                                                        </div>
                                                    </div>

                                                    <div class="form-row" style="margin-bottom: 2%">
                                                        <div class="form-group offset-2 col-md-6">
                                                            <label for="notes">Notes</label>
                                                            <textarea id="notes" name="notes" class="form-control">{{ $order->labTrack ? $order->labTrack->notes : '' }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="offset-2 col-3">
                                                            <button type="submit" class="btn btn-primary">Update Lab
                                                                Order</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                          

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

                        </tr>

                    </tfoot>

                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <!-- Modal for this specific lab order -->



@endsection
