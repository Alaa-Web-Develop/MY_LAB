@extends('layouts.mainLayout')
@section('title', 'Locations')
@push('styles')
<style>
    /* Ensure table takes full width */
    #example1 {
      width: 100%;
      border-collapse: collapse;
    }
  
    /* Make the header fixed */
    thead th {
      position: sticky;
      top: 0;
      background-color: #fff;
      z-index: 10;
    }
  
    /* Set a max height for the table body to allow scrolling */
    tbody {
      display: block;
      max-height: 300px; /* Adjust based on the desired scroll area */
      overflow-y: scroll;
    }
  
    /* Ensure that each row stays aligned properly */
    thead, tbody tr {
      display: table;
      width: 100%;
      table-layout: fixed;
    }
  
    /* Ensure the cells have consistent widths */
    th, td {
      width: 50%;
      padding: 8px;
      text-align: left;
      border: 1px solid #ddd;
    }
  </style>
    
@endpush
@section('content')
<div class="container">
    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1>Governorates and Cities</h1>

    <!-- Button to trigger Governorate modal -->
    <button class="btn btn-primary" data-toggle="modal" data-target="#addGovernorateModal">Add Governorate</button>
    <!-- Button to trigger City modal -->
    <button class="btn btn-secondary" data-toggle="modal" data-target="#addCityModal">Add City</button>

    <!-- Add Governorate Modal -->
    <div class="modal fade" id="addGovernorateModal" tabindex="-1" role="dialog" aria-labelledby="addGovernorateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('dashboard.governorates.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addGovernorateModalLabel">Add Governorate</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="governorate_name_ar">Governorate Name (Arabic)</label>
                            <input type="text" class="form-control" id="governorate_name_ar" name="governorate_name_ar" required>
                        </div>
                        <div class="form-group">
                            <label for="governorate_name_en">Governorate Name (English)</label>
                            <input type="text" class="form-control" id="governorate_name_en" name="governorate_name_en" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add City Modal -->
    <div class="modal fade" id="addCityModal" tabindex="-1" role="dialog" aria-labelledby="addCityModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('dashboard.cities.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCityModalLabel">Add City</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <<span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="governorate_id">Governorate</label>
                            <select class="form-control" id="governorate_id" name="governorate_id" required>
                                <option value="">Select Governorate</option>
                                @foreach($governorates as $governorate)
                                    <option value="{{ $governorate->id }}">{{ $governorate->governorate_name_en }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="city_name_ar">City Name (Arabic)</label>
                            <input type="text" class="form-control" id="city_name_ar" name="city_name_ar" required>
                        </div>
                        <div class="form-group">
                            <label for="city_name_en">City Name (English)</label>
                            <input type="text" class="form-control" id="city_name_en" name="city_name_en" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Governorates and Cities Listing -->
<div>
    <hr>
</div>
    <table class="table table-bordered bg-white" id="example1">
        <thead>
            <tr>
                <th>Governorate</th>
                <th>City</th>
            </tr>
        </thead>
        <tbody>
            @foreach($governorates as $governorate)
                <tr>
                    <td>{{ $governorate->governorate_name_en }}</td>
                    <td>
                        @foreach($governorate->cities as $city)
                            <span>{{ $city->city_name_en }}</span><br>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection