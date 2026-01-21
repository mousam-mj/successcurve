
@extends('layout3')
@section('title')
Register
@endsection
@section('content')

<div class="login-main-box">
	<div class="login-container">
		<div class="login-wrapper">
			<div class="title"><span>Register Now</span></div>
			@if(Session::get('errors'))
		
			<div class="alert alert-danger">
				{{ $errors }}
			</div>

			@endif
		<form action="{{url('register')}}" method="post">
			@csrf
			<div class="row">
				<i class="fas fa-user"></i>
				<input type="text" name="name" placeholder="Full Name" required>
			</div>
			<div class="row">
				<i class="fas fa-at"></i>
				<input type="email" name="email" placeholder="Email" required>
			</div>
			<div class="row">
				<i class="fas fa-mobile-android-alt"></i>
				<input type="number" name="contact" min="6000000000" max="9999999999"  placeholder="Number" required>
			</div>
			<div class="row">
				<i class="fas fa-lock"></i>
				<input type="password" name="password"  placeholder="Password" required>
			</div>
			<div class="row button">
				<input type="submit" value="Register">
			</div>
			<div class="signup-link">Already a member? <a href="{{ url('login') }}">Login now</a></div>
		</form>
		</div>
	</div>
</div>

@endsection



