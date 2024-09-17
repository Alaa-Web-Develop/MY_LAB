@extends('layouts.blankLayout')
@section('authPage')
<div class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="{{asset('dist/img/logo.png')}}" alt="logo">

        </div>
        <!-- /.login-logo -->
        <div class="card">
          <div class="card-body login-card-body">
            <p class="login-box-msg">This is a secure area of the application. Please confirm your password before continuing.</p>

            @error('password')
            <p class="text-danger">{{$message}}</p>  
            @enderror

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>
                  </div>

              <div class="row">
                <div class="col-12">
                  <button type="submit" class="btn btn-primary btn-block">Confirm</button>
                </div>
                <!-- /.col -->
              </div>
            </form>
      
           
          </div>
          <!-- /.login-card-body -->
        </div>
      </div>
      <!-- /.login-box -->
</div>
@endsection