@extends('layouts.mainLayout')
@section('title', 'Patient Test Tracking')

@section('content')

    <!-- Main content -->

    <div class="col">
        <div class="card">

            {{-- 'patient_id', 'doctor_id', 'test_id', 'lab_branche_id', 'expected_delivery_date', 'status', 'delivered_at', 'result', 'notes' --}}
            {{-- Patient Name
            Doctor Name
            Test Name
            Status
            Expected Delivery Date
            Delivery At
            Results
            ويكون في خانة بعد الـ Results اسمها Actions فيها زرارين Update و More ويكون  Moreدا عباره عن زرار لما نضغط عليه يفتح Popup يظهرر فيه كل البيانات اللي في الجدول واللي ناقصه علي هيئه كارت يظهر كل البيانات فيه تحت بعض مش جنب بعض.
            والـ Order ID نحذفه خالص ملوش لازمه.
             --}}
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped text-center">
                    <thead style="background-color: rgba(255, 187, 0, 0.563)">
                        <tr>
                            {{-- <th>Order ID</th> --}}

                            <th>Patient Name</th>
                            <th>Doctor Name</th>
                            <th>Test Name</th>
                            <th>Status</th>
                            <th>Expected Delivery Date</th>
                            <th>Delivered At</th>
                            <th>Results</th>
                            <th>Actions</th>

                            {{-- <th>Patient Discount Points</th>
                            <th>Test Price</th>
                            <th>Notes</th> --}}

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($labOrders as $labOrder)
                            <tr>
                                {{-- <td>{{ $labOrder->id }}</td> --}}
                                <td>{{ $labOrder->patient ? $labOrder->patient->full_name : '' }}</td>
                                <td>{{ $labOrder->doctor ? $labOrder->doctor->name : '' }}</td>
                                <td>{{ $labOrder->test ? $labOrder->test->name : '' }}</td>

                                <td style="font-size: 18px;"><span
                                        class="badge badge-{{ $labOrder->labTrack && $labOrder->labTrack->status === 'pending' ? 'warning' : 'success' }}">{{ $labOrder->labTrack ? ucfirst($labOrder->labTrack->status) : '' }}</span>
                                </td>

                                <td>{{ $labOrder->labTrack ? $labOrder->labTrack->expected_delivery_date : '' }}</td>
                                <td>{{ $labOrder->labTrack ? $labOrder->labTrack->delivered_at : '' }}</td>
                                <td>
                                    @if ($labOrder->labTrack && $labOrder->labTrack->result)
                                        <a href="{{ route('dashboard.download-lab-docs', $labOrder->id) }}"
                                            class="btn btn-primary"><i class="bi bi-cloud-arrow-down"></i></a>
                                    @else
                                        No files uploaded
                                    @endif
                                </td>
                                <td>

                                    <!-- Link to trigger modal -->
                                    <a href="{{ route('dashboard.track-lab_orders.edit', $labOrder->id) }}"
                                        class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#updateLabOrderModal{{ $labOrder->id }}">Update</a>

                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#MoreLabOrderModal{{ $labOrder->id }}">More</a>

                                </td>
                                {{-- <td>{{ $labOrder->labTest ? $labOrder->labTest->discount_points : '' }}</td>
                               
                                <td>{{ $labOrder->labTest ? $labOrder->labTest->price : '' }}</td>
                              
                                <td>{{ $labOrder->labTrack ? $labOrder->labTrack->notes :'' }}</td> --}}

                                {{-- <!-- Link to trigger modal -->
                        <a href="{{ route('dashboard.track-lab_orders.edit', $labOrder->id) }}" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateLabOrderModal{{ $labOrder->id }}" data-id="{{ $labOrder->id }}">Update</a>
  
                        </a>
                                 --}}


                                {{-- Modal Update --}}
                                <div class="modal fade" id="updateLabOrderModal{{ $labOrder->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="updateLabOrderModalLabel{{ $labOrder->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document"
                                        style="max-width: 50%; max-height:70%; overflow-y:hidden;">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="updateLabOrderModalLabel{{ $labOrder->id }}">
                                                    Update Lab Order</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form
                                                    action="{{ route('dashboard.track-lab_orders.update', $labOrder->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="form-row" style="margin-bottom: 2%">
                                                        <div class="form-group offset-2 col-md-3">
                                                            <label for="expected_delivery_date">Expected Delivery
                                                                Date</label>
                                                            <input type="datetime-local" id="expected_delivery_date"
                                                                name="expected_delivery_date" class="form-control"
                                                                value="{{ $labOrder->labTrack ? $labOrder->labTrack->expected_delivery_date : '' }}">
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label for="status">Status</label>
                                                            <select name="status" id="status" class="form-control">
                                                                <option value="pending"
                                                                    {{ $labOrder->labTrack && $labOrder->labTrack->status === 'pending' ? 'selected' : '' }}>
                                                                    Pending</option>
                                                                <option value="delivered"
                                                                    {{ $labOrder->labTrack && $labOrder->labTrack->status === 'delivered' ? 'selected' : '' }}>
                                                                    Delivered</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label for="delivered_at">Delivered At</label>
                                                            <input type="datetime-local" id="delivered_at"
                                                                name="delivered_at" class="form-control"
                                                                value="{{ $labOrder->labTrack ? $labOrder->labTrack->delivered_at : '' }}">
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
                                                            <textarea id="notes" name="notes" class="form-control">{{ $labOrder->labTrack ? $labOrder->labTrack->notes : '' }}</textarea>
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
                                {{-- Modal Update --}}

                                {{-- ============================================ --}}
                                {{-- Modal More --}}
                                <div class="modal fade" id="MoreLabOrderModal{{ $labOrder->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="MoreLabOrderModal{{ $labOrder->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document"
                                        style="max-width: 40%; max-height:70%; overflow-y:hidden;">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="MoreLabOrderModal{{ $labOrder->id }}">
                                                    Lab Order Details</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-row" style="margin-bottom: 2%">
                                                    <div class="form-group col-md-4">
                                                        <label>Patient Name</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $labOrder->patient ? $labOrder->patient->full_name : '' }}" readonly>
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label>Doctor Name</label>
                                                        <input disabled type="text" class="form-control"
                                                            value="{{ $labOrder->doctor ? $labOrder->doctor->name : '' }}"> 
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label>Test Name</label>
                                                        <input disabled type="text" class="form-control"
                                                        value="{{ $labOrder->test ? $labOrder->test->name : '' }}"> 
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label>Test Price</label>
                                                        <input type="text" disabled 
                                                           class="form-control"
                                                            value="{{ $labOrder->labTest ? $labOrder->labTest->price : '' }}">
                                                    </div>
                                                </div>




                                                <div class="form-row" style="margin-bottom: 2%">
                                                    <div class="form-group col-md-2">
                                                        <label>Discount 1% =</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $labOrder->labTest ? $labOrder->labTest->discount_points : '' }}" readonly>
                                                    </div>

                                                    <div class="form-group col-md-9">
                                                        <label>Notes</label>
                                                        <input disabled type="text" class="form-control"
                                                            value="{{ $labOrder->labTrack ? $labOrder->labTrack->notes :'' }}"> 
                                                    </div>
                                                   
                                                </div>









                                                <div class="form-row" style="margin-bottom: 2%">
                                                    <div class="form-group col-md-2">
                                                        <label>Order_Id</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $labOrder->id ? $labOrder->id : '' }}" readonly>
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <label>Expected Delivery Date</label>
                                                        <input disabled type="datetime-local" class="form-control"
                                                            value="{{ $labOrder->labTrack ? $labOrder->labTrack->expected_delivery_date : '' }}"> 
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label>Status</label>
                                                        <select class="form-control" disabled>
                                                            <option
                                                             value="pending" @selected($labOrder->labTrack && $labOrder->labTrack->status === 'pending')
                                                             >
                                                             pending
                                                            </option>
                                                            <option value="delivered"
                                                            value="delivered" @selected($labOrder->labTrack && $labOrder->labTrack->status === 'delivered')
                                                                >
                                                                delivered
                                                                
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label>Delivered At</label>
                                                        <input type="datetime-local" disabled 
                                                           class="form-control"
                                                            value="{{ $labOrder->labTrack ? $labOrder->labTrack->delivered_at : '' }}">
                                                    </div>
                                                </div>

                                                {{-- <div class="form-row" style="margin-bottom: 2%">
                                                    <div class="form-group offset-2 col-md-6">
                                                        <label for="notes">Notes</label>
                                                        <textarea id="notes" name="notes" class="form-control">{{ $labOrder->labTrack ? $labOrder->labTrack->notes : '' }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="offset-2 col-3">
                                                        <button type="submit" class="btn btn-primary">Update Lab
                                                            Order</button>
                                                    </div>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Modal More --}}
                                {{-- ============================================ --}}

                            </tr>
                            {{-- @include('dashboard.labOrdersTracking.labOrderEdit') --}}
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
                            {{-- <th></th>
                            <th></th>
                            <th></th>
                            <th></th> --}}

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

{{-- Notices================================= --}}
{{-- 
The ucfirst function takes a string and returns the same string with the first character converted to uppercase. If the string is empty or the first character is not a letter, it remains unchanged. --}}


{{-- <input type="datetime-local" id="expected_delivery_date"    expected_delivery_date	timestamp  --}}
