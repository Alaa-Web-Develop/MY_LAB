{{-- ============================== Modal Edit============================ --}}

<div class="modal fade" id="ModalAssignTestInfo{{ $lab->id }}" tabindex="-1" aria-labelledby="exampleModalLabe22"
    aria-hidden="true">
    <div class="modal-dialog" style="max-width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabe22">Add Test info
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- Errors======================== --}}
            @if ($errors->any())
                <div class="text-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {{-- Errors======================== --}}


            <form class="form-horizontal" action="{{ route('dashboard.lab_barnch_test.store') }}" method="post">
                @csrf
                <input type="hidden" class="form-control" name="lab_id" value="{{ $lab->id }}">

                {{-- 'lab_id', 'test_id', 'price', 'points', 'notes' --}}


                <div class="modal-body">
                    <div class="form-row" style="margin-bottom: 2%">

                        <div class="form-group offset-2 col-md-3">
                            <label>Lab Name</label>

                            <input type="text" class="form-control" disabled value="{{ $lab->name }}">


                        </div>

                        @php
                            $tests = \App\Models\Test::all();
                        @endphp
                        <div class="form-group  col-md-3">
                            <label>Test</label>
                            <select name="test_id" class="form-control">
                                @foreach ($tests as $test)
                                    <option value="{{ $test->id }}">{{ $test->name }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group  col-md-3">
                            <label>1% Discount =</label>
                            <input type="number" min="0" class="form-control" name="discount_points"
                                placeholder="points">

                        </div>



                    </div>


                    <div class="form-row" style="margin-bottom: 2%">
                        <div class="form-group offset-2 col-md-3">
                            <label>Price</label>
                            <input type="number" step="0.50" min="0" name="price" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Earned Points</label>
                            <input type="number" class="form-control" name="points">
                        </div>
                    </div>

                    <span class="bg-primary p-2">Courier</span>
                    <hr/>               

                    <div class="form-row d-flex align-items-center justify-content-start" style="margin-bottom:10px">
                        <div class="col-3 d-flex align-items-center">
                            <label>Has Courier ?</label>
                        </div>
                        <div class="col-6">
                            {{-- <input type="checkbox" name="has_courier" class="form-check-input" value="1"> --}}

                            <div class="d-flex align-items-center">
                                <input type="checkbox" name="has_courier" id="has_courier" class="form-check-input mr-2" value="1">
                                <label for="has_courier" class="form-check-label">Yes</label>
                            </div>

                        </div>

                        {{-- <div class="form-check">
                            <input type="checkbox" name="has_courier" id="has_courier" class="form-check-input" value="1" {{ old('has_courier', $labBranchTest->has_courier ?? 0) ? 'checked' : '' }}>
                            <label for="has_courier" class="form-check-label">Yes</label>
                        </div> --}}

                    </div>

                    <div class="form-row" style="align-items: baseline;margin-bottom:10px">
                        <div class="col-3">
                            <label>Courier</label>
                        </div>
                        <div class="col-6">
                            @php
                                $couriers = \App\Models\Courier::get();
                            @endphp
                            <select name="courier_id" id="courier_id" class="form-control">
                                <option value="">Select Courier</option>
                                @foreach ($couriers as $courier)
                                    <option value="{{ $courier->id }}">{{ $courier->name }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>



                    
                    <hr>
                    <span class="bg-success p-2">Sponsor</span>
                   
                    {{-- sposnor info ====================== --}}
                    <div class="form-row" style="margin-bottom: 2%">

                        @php
                            $sponsors = \App\Models\Sponser::all();
                        @endphp

                        <div class="form-group offset-2 col-md-4">
                            <label>Sponsor</label>
                            <select name="sponser_id" class="form-control" id="sponsorSelect">
                                <option value="" selected>None</option>
                                @foreach ($sponsors as $sponser)
                                    <option value="{{ $sponser->id }}" data-image="{{ asset($sponser->logo) }}">
                                        {{ $sponser->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Sponsored Image</label>
                            <div id="sponsorImage" style="text-align: center;">
                                <img src="" alt="Sponsor Image"
                                    style="max-width: 100px; max-height: 100px; display: none;">
                            </div>
                        </div>

                    </div>
                    {{-- sposnor info ====================== --}}
                    <hr>

                    <div class="form-row" style="margin-bottom: 2%">
                        <div class="form-group offset-2 col-md-9">

                            <textarea class="form-control" name="notes" cols="100" rows="3" placeholder="Notes....!"></textarea>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
            </form>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        $(document).ready(function() {
           // Toggle courier select based on the checkbox
 // Modal trigger function to handle enabling/disabling of the courier field
//  $('#ModalAssignTestInfo{{ $lab->id }}').on('shown.bs.modal', function () {
//                 // Check the checkbox status when the modal is opened
//                 var isChecked = $('#has_courier_{{ $lab->id }}').is(':checked');
//                 $('#courier_id_{{ $lab->id }}').prop('disabled', !isChecked);
//             });

$('#courier_id').prop('disabled', true);

        $('#has_courier').on('change',function(){
var isChecked=$(this).is(':checked');
$('#courier_id').prop('disabled',!isChecked);
        });
            $('#sponsorSelect').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var imageUrl = selectedOption.data('image');
                var $image = $('#sponsorImage img');

                if (imageUrl) {
                    $image.attr('src', imageUrl).show();
                } else {
                    $image.attr('src', '').hide();
                }
            });
        });
    </script>
@endpush
{{-- @push('scripts')

<script>
$(document).ready(function() {

    //$('select[id^="lab-select-"]').on('change', function() {
       // var labId = $(this).val();
       // var index = $(this).attr('id').split('-').pop(); // Extract the index from the ID

    // Event handler for when the selected lab changes
    $('select[id^="labSelect-"]').on('change', function() {
        var labId = $(this).val();
        var index = $(this).attr('id').split('-').pop(); // Extract the index from the ID
        //alert(labId)
        if (labId) {
            // Fetch branches based on the selected lab
            $.ajax({
                url: '/dashboard/branches/fetch/'+labId, // Ensure this URL is correct
                method: 'GET',
                //data: { lab_id: labId },
                dataType: 'json',
                success: function(data) {
                    var branchSelect = $('#branchSelect-'+index);
                    branchSelect.empty(); // Clear existing options
                    branchSelect.append('<option value="">Select Branch</option>'); // Default option
                    $.each(data, function(index, branch) {
                        branchSelect.append($('<option>', {
                            value: branch.id,
                            text: branch.name
                        }));
                    });
                },
                error: function(xhr) {
                    console.error('Error fetching branches:', xhr);
                }
            });
        } else {
            $('#branchSelect').empty(); // Clear branches if no lab is selected
            $('#branchSelect').append('<option value="">Select Branch</option>'); // Default option
        }
    });
});
</script>
@endpush --}}
