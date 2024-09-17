<!-- Modal (outside the loop) -->
<div class="modal fade" id="updateLabOrderModal{{$labOrder->id}}" tabindex="-1" role="dialog" aria-labelledby="updateLabOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 50%; max-height:70%; overflow-y:hidden;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateLabOrderModalLabel">Update Lab Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.track-lab_orders.update', $labOrder->id) }}" method="POST" enctype="multipart/form-data" id="labOrderForm">
                    @csrf
                    @method('PUT')

                    {{-- <div class="form-row">
                        <div class="col-2">
                        <label for="expected_delivery_date">Expected Delivery Date</label>
                        </div>
                        <div class="col-6">
                            <input type="date" id="expected_delivery_date" name="expected_delivery_date" class="form-control" value="{{ old('expected_delivery_date') }}">
                        </div>
                    </div> --}}

                    <div class="form-row"  style="margin-bottom: 2%">
                        <div class="form-group offset-2 col-md-3">
                            <label for="expected_delivery_date">Expected Delivery Date</label>
                        <input type="date" id="expected_delivery_date" name="expected_delivery_date" class="form-control" value="{{ $labOrder->labTrack? $labOrder->labTrack->expected_delivery_date:'' }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="pending">Pending</option>
                                <option value="delivered">Delivered</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="delivered_at">Delivered At</label>
                            <input type="datetime-local" id="delivered_at" name="delivered_at" class="form-control" value="{{ $labOrder->labTrack ?$labOrder->labTrack->delivered_at:''}}">
                        </div>

                    </div>


                    <div class="form-row"  style="margin-bottom: 2%">
                        <div class="form-group offset-2 col-md-6">
                            <label for="results">Upload Results</label>
                        <input type="file" name="results[]" id="results" class="form-control" multiple>
                        </div>
                    </div>

                    
                    <div class="form-row"  style="margin-bottom: 2%">
                        <div class="form-group offset-2 col-md-6">
                            <label for="notes">Notes</label>
                            <textarea id="notes" name="notes" class="form-control">{{ $labOrder->labTrack ?$labOrder->labTrack->notes:''}}</textarea>
                        </div>
                    </div>

                  

                 

                    {{-- <div class="form-group">
                        <label for="expected_delivery_date">Expected Delivery Date</label>
                        <input type="date" id="expected_delivery_date" name="expected_delivery_date" class="form-control" value="{{ old('expected_delivery_date') }}">
                    </div> --}}

                    {{-- <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="pending">Pending</option>
                            <option value="delivered">Delivered</option>
                        </select>
                    </div> --}}

                    {{-- <div class="form-group">
                        <label for="delivered_at">Delivered At</label>
                        <input type="datetime-local" id="delivered_at" name="delivered_at" class="form-control" value="{{ old('delivered_at') }}">
                    </div>

                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea id="notes" name="notes" class="form-control">{{ old('notes') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="results">Upload Results</label>
                        <input type="file" name="results[]" id="results" class="form-control" multiple>
                    </div> --}}
                    <div class="form-roe">
                        <div class="offset-2 col-3">
                            <button type="submit" class="btn btn-primary">Update Lab Order</button>
                        </div>
                    </div>
                   
                </form>
            </div>
        </div>
    </div>
</div>