@extends('layouts.mainLayout')
@section('title', 'edit lab profile')

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
        <form class="form-horizontal" action="{{ route('dashboard.labs.update',$lab->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="card-body">
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2" style="text-align:end;">
                        <label for="">Lab Name</label>
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control" name="name" value="{{ $lab->name }}" placeholder="enter lab name">
                    </div>
                </div>
                {{-- ==== --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-4" style="text-align:end;">
                       <img src="{{ asset($lab->logo) }}" class="w-50 h-50" alt="lab_img">
                    </div>
               
                    <div class="col-6">
                        <input type="file" class="form-control" name="logo" placeholder="" accept="image/*">
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
                                <option value="{{ $govr->id }}" @selected($lab->governorate_id==$govr->id)>{{ $govr->governorate_name_ar }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- ==== #govrs-id  #city-id --}}
                {{-- ==== --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2" style="text-align:end;">
                        <label for="">city</label>
                    </div>
                    <div class="col-4">
                        <select id="city-id" class="form-control" name="city_id">
                            <option value="" selected>Choose...</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}" @selected($lab->city_id==$city->id)>{{ $city->city_name_ar }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- ==== --}}

                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2" style="text-align:end;">
                        <label for="">Address</label>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control" name="address" value="{{$lab->address}}" placeholder="enter address details..">
                    </div>
                </div>

                {{-- ==== --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2" style="text-align:end;">
                        <label for="">Location</label>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control" name="location" value="{{ $lab->location }}" placeholder="enter location details..">
                    </div>
                </div>
                {{-- ==== --}}
                {{-- ==== --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2" style="text-align:end;">
                        <label for="">phone</label>
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" name="phone" value="{{ $lab->phone }}" placeholder="Enter phone number..">
                    </div>
                </div>
                {{-- ==== --}}
                {{-- ==== --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2" style="text-align:end;">
                        <label for="">hotline</label>
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" name="hotline" value="{{ $lab->hotline }}" placeholder="Enter HotLine Number..">
                    </div>
                </div>
                {{-- ==== --}}
                {{-- ==== --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2" style="text-align:end;">
                        <label for="">Email</label>
                    </div>
                    <div class="col-6">
                        <input type="email" class="form-control" name="email" value="{{ $lab->email }}" placeholder="Enter lab email..">
                    </div>
                </div>
                {{-- ==== --}}
                {{-- ==== --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2" style="text-align:end;">
                        <label for="">Approval_Status</label>
                    </div>
                    <div class="col-4">
                        <select id="inputAddress" class="form-control" name="Approval_Status">
                            <option value="pending" @selected($lab->Approval_Status=="pending")>pending</option>
                            <option value="approved" @selected($lab->Approval_Status=="approved")>approved</option>
                        </select>
                    </div>
                </div>
          
            {{-- ==== --}}
                            {{-- ==== --}}
                       
                            {{-- ==== --}}

            <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                <div class="col-2" style="text-align:end;">
                    <label for="">description</label>
                </div>
                <div class="col-6">

                    <textarea class="form-control" name="description" id="inputEmail205" cols="30" rows="5"
                        placeholder="Lab description & Notes....!">{{ $lab->description }}</textarea>
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