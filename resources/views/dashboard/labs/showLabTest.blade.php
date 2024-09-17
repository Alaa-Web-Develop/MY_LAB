@extends('layouts.mainLayout')
@section('title', 'Lab| Tests')

@section('content')

    <div class="col" style="width: 90%;">
        <div class="card p-4">
            
            <h3 class="text-center p-2" style="background-color: #e7ffa8;"><span class="text-danger" style="text-decoration: underline">{{ $lab_name }}</span> Tests</h3>
            <table class="table table-bordered">
                <thead style="background-color: #d4eaf3">
                    <tr>
                        <th>Test Name</th>
                        <th>Price</th>
                        <th>Points</th>
                        <th>Discount Points</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tests as $test)
                        <tr>
                            <td>{{ $test['name'] }}</td>
                            <td>{{ $test['price'] }}</td>
                            <td>{{ $test['points'] }}</td>
                            <td>{{ $test['discount_points'] }}</td>
                            <td>{{ $test['notes'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
