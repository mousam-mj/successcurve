
@extends('layout3')
@section('title')
Login
@endsection
@section('content')

 <div class="login-main-box">
	<div class="login-container">
		<div class="login-wrapper">
			<div class="title"><span>Welcome, Back</span></div>
			
			@if(Session::get('errors'))
			<div class="alert alert-danger">
				{{ $errors }}
			</div>
			@endif

		  <form action="{{url('login')}}" method="post">
			@csrf
			<div class="row">
			  <i class="fas fa-user"></i>
			  <input type="text" id="email" name="email" placeholder="Email" required>
			</div>
			<div class="row">
			  <i class="fas fa-lock"></i>
			  <input type="password" name="password" id="password" placeholder="Password" required>
			</div>
			<div class="pass"><a href="{{ url('forget') }}">Forgot password?</a></div>
			<div class="row button">
			  <input type="submit" value="Login">
			</div>
			<div class="signup-link">Not a member? <a href="{{ url('register') }}">Signup now</a></div>
		  </form>
		</div>
	  </div>
 </div>

@endsection
