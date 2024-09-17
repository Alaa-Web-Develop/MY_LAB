@extends('layouts.mainLayout')
@section('title', 'Edit institution')

@section('content')

    <div class="card" style="width: 40%;margin:auto">

        <div class="card-header">
            <h3 class="card-title">edit institution {{$inst->name}}</h3>
        </div>

        @if ($errors->any())
        <div class="text-danger">
            <ul>
                @foreach ($errors->all() as $error )
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
            
        @endif
        <!-- /.card-header -->
        <!-- form start -->
        <form class="form-horizontal" action="{{ route('dashboard.institutions.update',$inst->id) }}" method="post">
            @csrf
            @method('put')

            <div class="card-body">
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">name</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" value="{{$inst->name}}" placeholder="enter institution name" class="form-control">
                    </div>
                </div>


            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-info">edit</button>

            </div>
            <!-- /.card-footer -->
        </form>
    </div>
    <!-- /.card -->
@endsection
