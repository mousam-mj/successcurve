
@extends('layout3')
@section('title')
Login
@endsection
@section('content')

<div class="login-main-box">
	<div class="login-container">
		<div class="login-wrapper">
			<div class="title"><span>Forget Password</span></div>
			
			@if(Session::get('errors'))
			<div class="alert alert-danger">
				{{ $errors }}
			</div>
			@endif
			
		  <form action="{{url('forgetPassword')}}" method="post">
			@csrf
			<div class="row">
			  <i class="fas fa-user"></i>
			  <input type="text" id="email" name="email" placeholder="Email " required>
			</div>
			
			<div class="row button">
			  <input type="submit" value="Forget Password">
			</div>
			<div class="signup-link"> <a href="{{ url('login') }}">Go to Login</a></div>
		  </form>
		</div>
	  </div>
 </div>

@endsection
