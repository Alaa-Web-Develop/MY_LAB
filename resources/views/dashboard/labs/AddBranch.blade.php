{{-- ============================== Modal Edit============================ --}}

<div class="modal fade" id="ModalAddBranches{{ $lab->id }}" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Add Branche
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                
               
                @if ($errors->any())
                <div class="text-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
    
            @endif
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{ route('dashboard.lab_branches.store') }}" method="post">
                @csrf

                <input type="hidden" name="lab_id" value="{{$lab->id}}">
                <div class="card-body">
                    <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                        <div class="col-2" style="text-align:end;">
                            <label for="">lab_barnch Name</label>
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control" name="name" placeholder="enter lab name">
                        </div>
                    </div>
                    {{-- ==== --}}
                 
                    {{-- ==== --}}
                    {{-- ==== --}}
                    <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                        <div class="col-2" style="text-align:end;">
                            <label for="">Governorate</label>
                        </div>
                        <div class="col-4">
                            <select id="govrs-id" class="form-control" name="governorate_id">
    
                                <option value="" selected>Choose...</option>
   @php
       $govrs=\App\Models\Governorate::all();
   @endphp
                                @foreach ($govrs as $govr)
                                    <option value="{{ $govr->id }}">{{ $govr->governorate_name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- ==== --}}
                    {{-- ==== --}}

                    @php
                    $cities=\App\Models\City::all();
                @endphp

                    <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                        <div class="col-2" style="text-align:end;">
                            <label for="">city</label>
                        </div>
                        <div class="col-4">
                            <select id="city-id" class="form-control" name="city_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->city_name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- ==== --}}
                    {{-- ==== --}}
                    <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                        <div class="col-2" style="text-align:end;">
                            <label for="">Location</label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control" name="location" placeholder="enter location details..">
                        </div>
                    </div>
                    {{-- ==== --}}
                    {{-- ==== --}}
                    <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                        <div class="col-2" style="text-align:end;">
                            <label for="">phone</label>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" name="phone" placeholder="Enter phone number..">
                        </div>
                    </div>
                    {{-- ==== --}}
                    {{-- ==== --}}
                    <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                        <div class="col-2" style="text-align:end;">
                            <label for="">hotline</label>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" name="hotline" placeholder="Enter HotLine Number..">
                        </div>
                    </div>
                    {{-- ==== --}}
                    {{-- ==== --}}
                    <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                        <div class="col-2" style="text-align:end;">
                            <label for="">Email</label>
                        </div>
                        <div class="col-6">
                            <input type="email" class="form-control" name="email" placeholder="Enter lab email..">
                        </div>
                    </div>
                    {{-- ==== --}}
                    {{-- <div class="form-row" style="align-items: center;margin-bottom: 10px;">
    
                        <div class="col-2" style="text-align:end;">
                            <label for="">Branch Login</label>
                        </div>
                        @php
                        $users=\App\Models\User::all();
                    @endphp
                    <div class="col-4">
                        <select class="form-control" name="user_id">
    
                            <option value="" selected>Choose...</option>
    
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}
    
    
                    {{-- ==== --}}
                    <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                        <div class="col-2" style="text-align:end;">
                            <label for="">Approval_Status</label>
                        </div>
                        <div class="col-4">
                            <select id="inputAddress" class="form-control" name="Approval_Status">
                                <option value="pending">pending</option>
                                <option value="approved">approved</option>
                            </select>
                        </div>
                    </div>
              
                {{-- ==== --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2" style="text-align:end;">
                        <label for="">description</label>
                    </div>
                    <div class="col-6">
    
                        <textarea class="form-control" name="description" id="inputEmail205" cols="30" rows="5"
                            placeholder="Lab description & Notes....!"></textarea>
                    </div>
                </div>
                {{-- ==== --}}
    
        </div>
        {{-- =====================card-body --}}
    
        <!-- ====================card-footer -->
        <div class="card-footer" style="text-align: end;">
            <button type="submit" class="btn btn-info">Add</button>
    
        </div>
        <!-- /.=================card-footer -->
        </form>
        </div>
        <!-- /.card -->

    
                
            </div>

        </div>
    </div>
</div>

@push('scripts') 
    <script>
        $(document).ready(function() {
            $('#govrs-id').change(function() {
                var governId = $(this).val();
                //alert(governId);
                if (governId) {
                    $.ajax({
                        url: '/cities/' + governId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            //console.log(data);

                            //empty drop first
                            $('#city-id').empty().append('<option value="">Select a city</option>');
                            $.each(data, function(key, city) {
                                $('#city-id').append('<option value="' + city.id +
                                    '">' + city.city_name_ar + '</option>');
                            });
                        }

                    });
                } else {
                    $('#city-id').empty().append(' <option>Select a city...</option>');
                }

            });
        });
    </script>
@endpush
