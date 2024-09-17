@extends('layouts.mainLayout')
@section('title', 'Create New Lab ')

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
        <form class="form-horizontal" action="{{ route('dashboard.labs.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2" style="text-align:end;">
                        <label for="">Lab Name</label>
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control" name="name" placeholder="enter lab name">
                    </div>
                </div>
                {{-- ==== --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2" style="text-align:end;">
                        <label for="">Lab Logo</label>
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
                                <option value="{{ $govr->id }}">{{ $govr->governorate_name_ar }}</option>
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
                                <option value="{{ $city->id }}">{{ $city->city_name_ar }}</option>
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
                        <input type="text" class="form-control" name="address" placeholder="enter address details..">
                    </div>
                </div>
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
                        <label for="">Phone</label>
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" name="phone" placeholder="Enter phone number..">
                    </div>
                </div>
                {{-- ==== --}}
                {{-- ==== --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2" style="text-align:end;">
                        <label for="">Hotline</label>
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
                {{-- ==== --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2" style="text-align:end;">
                        <label for="">Approval Status</label>
                    </div>
                    <div class="col-4">
                        <select id="inputAddress" class="form-control" name="Approval_Status">
                            <option value="pending">pending</option>
                            <option value="approved">approved</option>
                        </select>
                    </div>
                </div>
          
            {{-- ==== --}}
        
            {{-- ==== --}}

            <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                <div class="col-2" style="text-align:end;">
                    <label for="">Description</label>
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