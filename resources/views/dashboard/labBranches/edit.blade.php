@extends('layouts.mainLayout')
@section('title', 'edit lab_Branch profile')

@section('content')

    <div class="card" style="width: 80%;margin:auto">

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
        <form class="form-horizontal" action="{{ route('dashboard.lab_branches.update',$LabBranch->id) }}" method="post" >
            @csrf
            @method('put')
            <div class="card-body">
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2" style="text-align:end;">
                        <label for="">Lab_barnch Name</label>
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control" name="name" value="{{ $LabBranch->name }}" placeholder="enter lab_branch name">
                    </div>
                </div>
                {{-- ==== --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-4" style="text-align:end;">
                        <label for="">Lab_barnch Name</label>

                    </div>
               
                    <div class="col-6">
                        <select class="form-control" name="lab_id">

                            <option selected>Choose...</option>

                            @foreach ($labs as $lab)
                                <option value="{{ $lab->id }}" @selected($LabBranch->lab_id==$lab->id)>{{ $lab->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- ==== --}}
                {{-- ==== --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2" style="text-align:end;">
                        <label for="">Governorate</label>
                    </div>
                    <div class="col-4">
                        <select id="govrs-id" class="form-control" name="governorate_id">

                            <option value="" selected>Choose...</option>

                            @foreach ($govrs as $govr)
                                <option value="{{ $govr->id }}" @selected($LabBranch->governorate_id==$govr->id)>{{ $govr->governorate_name_ar }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- ==== --}}
                {{-- ==== --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2" style="text-align:end;">
                        <label for="">city</label>
                    </div>
                    <div class="col-4">
                        <select id="city-id" class="form-control" name="city_id">
                            <option value="" selected>Choose...</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}" @selected($LabBranch->city_id==$city->id)>{{ $city->city_name_ar }}</option>
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
                        <input type="text" class="form-control" name="location" value="{{ $LabBranch->location }}" placeholder="enter location details..">
                    </div>
                </div>
                {{-- ==== --}}
                {{-- ==== --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2" style="text-align:end;">
                        <label for="">phone</label>
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" name="phone" value="{{ $LabBranch->phone }}" placeholder="Enter phone number..">
                    </div>
                </div>
                {{-- ==== --}}
                {{-- ==== --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2" style="text-align:end;">
                        <label for="">hotline</label>
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" name="hotline" value="{{ $LabBranch->hotline }}" placeholder="Enter HotLine Number..">
                    </div>
                </div>
                {{-- ==== --}}
                {{-- ==== --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2" style="text-align:end;">
                        <label for="">Email</label>
                    </div>
                    <div class="col-6">
                        <input type="email" class="form-control" name="email" value="{{ $LabBranch->email }}" placeholder="Enter lab email..">
                    </div>
                </div>
                {{-- ==== --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2" style="text-align:end;">
                        <label for="">User Login</label>
                    </div>
                    <div class="col-4">
                        <select class="form-control" name="user_id">
                            <option value="" selected>Choose...</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @selected($lab->user_id==$user->id)>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- ==== --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2" style="text-align:end;">
                        <label for="">Approval_Status</label>
                    </div>
                    <div class="col-4">
                        <select id="inputAddress" class="form-control" name="Approval_Status">
                            <option value="pending" @selected($LabBranch->Approval_Status=="pending")>pending</option>
                            <option value="approved" @selected($LabBranch->Approval_Status=="approved")>approved</option>
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
                        placeholder="Lab description & Notes....!">{{ $LabBranch->description }}</textarea>
                </div>
            </div>
            {{-- ==== --}}

    </div>
    {{-- =====================card-body --}}

    <!-- ====================card-footer -->
    <div class="card-footer" style="text-align: end;">
        <button type="submit" class="btn btn-info">Edit</button>

    </div>
    <!-- /.=================card-footer -->
    </form>
    </div>
    <!-- /.card -->
@endsection


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