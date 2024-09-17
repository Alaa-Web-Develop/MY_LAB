@extends('layouts.mainLayout')
@section('title', 'Doctors | Dcouments')


@section('content')

    <div>
        <div class="row">
            <div class="col-6">
                <h3 style="text-decoration: underline;color:blueviolet">Doctor Name : {{ $doctor->name }}</h3>
            </div>
            <div class="col-6">
                <a href="{{route('dashboard.doctors.index')}}" class="btn btn-success btn-sm" style="text-align: center;"><i class="bi bi-arrow-left"></i> Back</a>
            </div>
        </div>
       
        <div class="row">
            @foreach ($doctor_docs as $doc)
                <div class="mt-2 col-4">
                    <a href="{{ asset($doc->docs) }}" target="_blank"><img src="{{ asset($doc->docs) }}" class="w-100 h-100" alt="img" /></a>
                    <a href="{{ asset($doc->docs) }}" class="a-doctorcodsdownload" download=""><i class="bi bi-download"></i></a>
                </div>
            @endforeach
        </div>
    </div>

@endsection
