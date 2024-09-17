@extends('layouts.mainLayout')
@section('title', 'Dashboard')
@section('content')


    {{-- @dd($totalTestsRequested, $pendingLabOrders, $totalPointsEarned, $totalPointsRedeemed); --}}
    <!-- Main content -->

    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalTestsRequested }}</h3>

                <p>Lab Orders</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{ route('dashboard.track-lab_orders.index') }}" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $pendingLabOrders }}</h3>

                <p>Pending Lab Orders</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('dashboard.track-lab_orders.index') }}" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totalPointsEarned }}</h3>

                <p>Total Points Earned</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('dashboard.total.points.index') }}" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $totalPointsRedeemed }}</h3>

                <p>Total Points Discounts</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ route('dashboard.total.points.index') }}" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->

    <div class="col-12 p-2">
        <h3 class="text-center p-2" style="background-color: rgba(225, 255, 0, 0.436)">General Search</h3>
    </div>

    <div class="col-12">
        <form action="{{ route('dashboard.actions.filter') }}" method="GET">


            <div class="form-row" style="margin-bottom: 2%">
                <div class="form-group offset-3 col-md-3">
                    <label for="status">Type</label>
                    <select name="type" class="form-control">
                        <option value="">All Types</option>
                        <option value="doctors">Doctors</option>
                        <option value="patients">Patients</option>
                        <option value="lab_orders">Lab Orders</option>
                        <option value="points">Points</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="">Date</label>
                    <input type="date" name="action_date" class="form-control">
                </div>

                <div class="form-group col-md-2">
                    <button type="submit" class="btn btn-sm btn-warning" style="position: absolute;
    top: 34px;"><i
                            class="bi bi-search"></i></button>
                </div>

            </div>

        </form>
    </div>
    
@endsection
