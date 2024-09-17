@extends('layouts.mainLayout')
@section('title', 'Edit Doctor Profile')

@section('content')

    <div class="card" style="width: 80%;margin:auto">

        <div class="card-header">
            <h3 class="card-title">edit profile DR: <span
                    style="font-weight: bold;color:green;font-size: 22px;">{{ $doctor->name }}</span> </h3>
        </div>

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
        <form id="myform" class="form-horizontal" action="{{ route('dashboard.doctors.update', $doctor->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="card-body">
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2" style="text-align:end;">
                        <label for="">Doctor Name</label>
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control" value="{{ $doctor->name }}" name="name">
                    </div>
                </div>

                {{-- ================= --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2"style="text-align:end;">
                        <label for="" style="text-align: end;">Doctor Speciality</label>
                    </div>
                    <div class="col-4">
                        <select id="inputState" class="form-control" name="speciality_id">
                           
                            @foreach ($specs as $spec)
                                <option value="{{ $spec->id }}" @selected($spec->id == $doctor->speciality_id)>{{ $spec->name }}
                                </option>
                            @endforeach
                        </select>


                    </div>
                </div>
                {{-- ================= --}}
                {{-- ================= --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2"style="text-align:end;">
                        <label for="" style="text-align: end;">Doctor Institution</label>
                    </div>
                    <div class="col-4">
                        <select class="form-control" name="institution_id">

                            @foreach ($insts as $inst)
                                <option value="{{ $inst->id }}" @selected($inst->id == $doctor->institution_id)>{{ $inst->name }}</option>
                            @endforeach
                        </select>
                        
                    </div>
                </div>
                {{-- ================= --}}
                {{-- ================= --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2"style="text-align:end;">
                        <label for="" style="text-align: end;">Doctor Phone</label>
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" value="{{ $doctor->phone }}" name="phone">
                    </div>
                </div>
                {{-- ================= --}}
                {{-- ================= --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2"style="text-align:end;">
                        <label for="" style="text-align: end;">Doctor Email</label>
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control" value="{{ $doctor->email }}" name="email">
                    </div>
                </div>
                {{-- ================= --}}
                {{-- ================= --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2"style="text-align:end;">
                        <label for="" style="text-align: end;">Doctor Governorate</label>
                    </div>
                    <div class="col-4">
                        <select id="govrs-id" class="form-control" name="governorate_id">
                         
                            <option value="" selected>Choose...</option>
                            @foreach ($govrs as $govr)
                                <option value="{{ $govr->id }}" @selected($govr->id == $doctor->governorate_id)>{{ $govr->governorate_name_ar }}</option>
                            @endforeach
                        </select>

                        
                    </div>
                </div>
                {{-- ================= --}}
                {{-- ================= --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2"style="text-align:end;">
                        <label for="" style="text-align: end;">Doctor City</label>
                    </div>
                    <div class="col-4">
                        <select id="city-id" class="form-control" name="city_id">
                            <option value="" selected>Choose...</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}" @selected($city->id ==$doctor->city_id )>{{ $city->city_name_ar }}</option>
                            @endforeach
                        </select>

                        
                    </div>
                </div>
                {{-- ================= --}}
                {{-- ================= --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2"style="text-align:end;">
                        <label for="" style="text-align: end;">Doctor Approval_Status</label>
                    </div>
                    <div class="col-4">
                        <select name="Approval_Status" class="form-control">
                            <option value="pending" @selected($doctor->Approval_Status == 'pending')>pending</option>
                            <option value="approved" @selected($doctor->Approval_Status == 'approved')>approved</option>
                        </select>

                    </div>
                </div>
                {{-- ================= --}}

                {{-- <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2"style="text-align:end;">
                        <label for="" style="text-align: end;">user login</label>
                    </div>
                    <div class="col-4">
                        <select name="user_id" class="form-control">
                            <option value="" selected>Choose...</option>

                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @selected($user->id ==$doctor->user_id )>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}

                {{-- ================= --}}
                <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2"style="text-align:end;">
                        <label for="" style="text-align: end;">Doctor Documents</label>
                    </div>
                    <div class="col-6">
                        <input type="file" class="form-control" name="docs[]" multiple accept=".pdf, .txt,image/*" />
                    </div>

                </div>
                {{-- ================= --}}
                   {{-- ================= --}}
                   <div class="form-row" style="align-items: center;margin-bottom: 10px;">
                    <div class="col-2"style="text-align:end;">
                        <label for="" style="text-align: end;">Doctor Notes</label>
                    </div>
                    <div class="col-6">
                        <textarea cols="30" rows="5" class="form-control" name="doctor_notes">{{ $doctor->doctor_notes }}</textarea>
                    </div>

                </div>
            </form>
                  {{-- ================= --}}

  

            </div>
            <!-- /.card-body -->
            <div class="card-footer text-right ">
                <button type="submit" form="myform" class="btn btn-info ">Edit</button>
            </div>
            <!-- /.card-footer -->
        
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