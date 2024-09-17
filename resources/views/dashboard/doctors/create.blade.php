@extends('layouts.mainLayout')
@section('title', 'create doctor profile')

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
        <form class="form-horizontal" action="{{ route('dashboard.doctors.store') }}" method="post"
            enctype="multipart/form-data">
            @csrf
            {{-- style="background-color: antiquewhite;" --}}

            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home">doctor information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu1">contact information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu2">doctor documents</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content" style="
            padding: 30px;
        ">
                <div class="tab-pane container active" id="home">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Name</label>
                            <input type="text" class="form-control" name="name" id="inputEmail4"
                                placeholder="Doctor Name...!">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputState">Speciality</label>
                            <select id="inputState" class="form-control" name="speciality_id">
                                <option selected>Choose...</option>
                                @foreach ($specs as $spec)
                                    <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputAddress88">Institution</label>
                        <select id="inputAddress88" class="form-control" name="institution_id"
                            style="
                        width: 20%;
                    ">

                            <option selected>Choose...</option>
                            @foreach ($insts as $inst)
                                <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="form-group">
                        <label for="inputAddress">Approval_Status</label>
                        <select id="inputAddress" class="form-control" name="Approval_Status"
                            style="
                        width: 20%;
                    ">
                            <option value="pending">pending</option>
                            <option value="approved">approved</option>
                        </select>
                    </div>

                    {{-- <div class="form-group">
                        <label for="inputAddress12">User Login</label>
                        <select id="inputAddress12" class="form-control" name="user_id">
                            <option value="" selected>Choose...</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}


                </div>
                {{-- ====doc info end --}}
                <div class="tab-pane container fade" id="menu1">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail10">phone</label>
                            <input type="text" class="form-control" name="phone" id="inputEmail10"
                                placeholder="Doctor phone...!">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail20">email</label>
                            <input type="email" class="form-control" name="email" id="inputEmail20"
                                placeholder="Doctor email...!">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="govrs-id">governorate</label>
                            <select id="govrs-id" class="form-control" name="governorate_id">
                                <option selected>Choose...</option>
                                @foreach ($govrs as $govr)
                                    <option value="{{ $govr->id }}">{{ $govr->governorate_name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="city-id">city</label>
                            <select id="city-id" class="form-control" name="city_id">
                                <option selected>Choose...</option>
                                {{-- @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->city_name_ar }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>

                </div>
                <div class="tab-pane container fade" id="menu2">

                    <div class="form-group">
                        <label for="inputEmail202">upload doctor documents</label>
                        <input type="file" class="form-control p-1" name="docs[]" multiple accept=".pdf, .txt,image/*"
                            id="inputEmail202" placeholder="Doctor Documents...!">
                    </div>

                    <div class="form-group">
                        <label for="inputEmail205">notes</label>

                        <textarea class="form-control" name="doctor_notes" id="inputEmail205" cols="30" rows="5"
                            placeholder="Notes....!"></textarea>
                    </div>

                </div>
            </div>

            <!-- /.card-footer -->
            <div class="card-footer">
                <button type="submit" class="btn btn-info">save</button>

            </div>
            <!-- /.card-footer -->
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
{{-- <script>
    $(document).ready(function() {
        $('#country').change(function() {
            var countryId = $(this).val();
            
            if (countryId) {
                $.ajax({
                    url: '/cities/' + countryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#city').empty().append('<option value="">Select a city</option>');
                        $.each(data, function(key, city) {
                            $('#city').append('<option value="' + city.id + '">' + city.name + '</option>');
                        });
                    }
                });
            } else {
                $('#city').empty().append('<option value="">Select a city</option>');
            }
        });
    });
</script> --}}
