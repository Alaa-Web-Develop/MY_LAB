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
        <p class="login-box-msg">Sign in to start your session</p>
  
        @error('email')
        <p class="text-danger">{{$message}}</p>  
        @enderror

        @if (session('status'))
    <div>
        {{ session('status') }}
    </div>
@endif

        <form method="POST" action="{{ route('password.email') }}">
          @csrf

          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          
            <!-- /.col -->
            <div >
              <button type="submit" class="btn btn-primary btn-block">Email Password Reset Link</button>
            </div>
            <!-- /.col -->
          
        </form>
  
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->
  
<!-- /.login-box -->

</div>
@endsection