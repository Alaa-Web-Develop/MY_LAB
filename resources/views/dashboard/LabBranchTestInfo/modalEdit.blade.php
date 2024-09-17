{{-- ============================== Modal Edit============================ --}}

<div class="modal fade" id="ModalTestInfoEdit{{$test->test_id}}" tabindex="-1" aria-labelledby="exampleModalLabelinfo" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 60%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelinfo">Edit Test : {{ $test->test_name }}
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


            <form class="form-horizontal" action="{{ route('dashboard.tests.branches.update',['test_id' => $test->test_id, 'lab_id' => $test->lab_id]) }}" method="post">
                @csrf
                @method('put')
              
{{-- 
                <input type="hidden" name="test_id" value="{{ $test->test_id }}">
                <input type="hidden" name="lab_branche_id" value="{{ $test->branch_id }}"> --}}

           
                    {{-- 'lab_id', 'test_id', 'price', 'points', 'notes' --}}
    
                    <div class="modal-body">

                        <div class="form-row" style="margin-bottom: 2%">

                            <div class="form-group col-md-3">
                                <label>Lab Name</label>
    
                                <input type="text" class="form-control" readonly name="lab_id" value="{{$test->lab_id}}">
                            </div>
    
                            @php
                                $tests=\App\Models\Test::all();
                            @endphp
                            <div class="form-group  col-md-3">
                                <label>Test</label>
                                <select name="test_id" class="form-control">
                                    @foreach ( $tests as $tes )
                                        <option value="{{$tes->id}}" @selected($tes->id ===$test->test_id)>{{$tes->name}}</option>
                                    @endforeach
                                </select>
                               
                            </div>

                            <div class="form-group  col-md-3">
                                <label>1% Discount Equal</label>
                                <input type="number" min="0" class="form-control" name="discount_points" value="{{$test->discount_points}}">
                                <span>points</span> 
                            </div>

                         
                            {{-- <div class="form-group col-md-3">
                               
                                @php
                                    $labs=\App\Models\Lab::all();
                                @endphp
                                <label for="labSelect">Lab</label>
                                <select id="labSelect-{{$test->id}}" class="form-control">
                                    <option value="">Select Lab</option>
                                   @foreach ($labs as $lab )
                                    <option value="{{$lab->id}}">{{$lab->name}}</option>    
                                   @endforeach
                                </select>
                            </div> --}}
                            {{-- <div class="form-group col-md-3">
                                <label for="branchSelect">Branche</label>
                                <select id="branchSelect-{{$test->id}}" class="form-control" name="lab_branche_id">
                                    <option value="">Select Branch</option>
                                    <!-- Options will be populated based on selected lab -->
                                </select>
                            </div> --}}
                        </div>
    
    
                        <div class="form-row"  style="margin-bottom: 2%">
                            <div class="form-group offset-2 col-md-3">
                                <label>Price</label>
                                <input type="number" step="0.50" min="0" value="{{$test->test_price}}" name="price" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Doctor Earned Points</label>
                                <input type="number" class="form-control" value="{{$test->doctor_points}}" name="points" >
                            </div>
                        </div>
    
                        <div class="form-row"  style="margin-bottom: 2%">
                            <div class="form-group offset-2 col-md-9">
                               
                                <textarea class="form-control" name="notes" cols="100" rows="3" placeholder="Notes....!">{{$test->notes}}</textarea>
                            </div>
                        </div>


                        {{-- <div class="form-row" style="margin-bottom: 2%">
                            <div class="form-group offset-2 col-md-3">
                                <label>Test</label>
                                <input type="text" disabled class="form-control" value="{{ $test->test_name }}">
                            </div>
                            <div class="form-group col-md-3">
                               
                                @php
                                    $labs=\App\Models\Lab::all();
                                @endphp
                                <label for="labSelect">Lab</label>
                                <select id="labSelect-{{$test->test_id}}" class="form-control">
                                   
                                   @foreach ($labs as $lab )
                                    <option value="{{$lab->id}} @selected($lab->id ===$test->lab_id)">{{$lab->name}}</option>    
                                   @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="branchSelect">Branche</label>
                                <select id="branchSelect-{{$test->test_id}}" class="form-control" name="lab_branche_id">
                                    <option value="{{$test->branch_id}}">{{$test->branch}}</option>
                                    <!-- Options will be populated based on selected lab-->
                                  
                                    
                                </select>
                            </div>
                        </div>
    
    
                        <div class="form-row"  style="margin-bottom: 2%">
                            <div class="form-group offset-2 col-md-3">
                                <label>Price</label>
                                <input type="number" value="{{ $test->test_price }}" step="0.50" min="0" name="price" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Doctor Points</label>
                                <input type="number" value="{{ $test->doctor_points }}" class="form-control" name="points" >
                            </div>
                        </div>
    
                        <div class="form-row"  style="margin-bottom: 2%">
                            <div class="form-group offset-2 col-md-9">
                               
                                <textarea class="form-control" name="notes" cols="100" rows="3" placeholder="Notes....!">{{ $test->notes }}</textarea>
                            </div>
                        </div> --}}
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>


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
                    //branchSelect.append('<option value="">choose branch..</option>'); // Default option
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
