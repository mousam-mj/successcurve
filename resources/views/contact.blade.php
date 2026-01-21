

@extends('layout')
@section('title')
Contact us 
@endsection
@section('content')

<div class="main-box" style="min-height: 50vh;">
    <div class="mt-70"></div>
    <div class="aboutsec">
        
        <div class="row">
            <div class="col-lg-6">
                <div class="contact-inner one">
                    <h1 class="con-h1">Find Us</h1>
                    <ul class="fa-ul">
                        <li>
                            <img src="{{ asset('imgs/logo.png') }}" alt="" class="clogoc">
                        </li>
                        <li class="mt-30 cli">
                            <span class="fa-li cicn"><i class="far fa-building"></i></span>
                            Sudhi Appartment, Forbesganj, Bihar - 854318.
                        </li>
                        <li class="mt-30 cli">
                            <span class="fa-li cicn"><i class="fas fa-envelope-open-text"></i></span>
                            hello@successcurve.in
                        </li>
                        <li class="mt-30 cli">
                            <span class="fa-li cicn"><i class="fas fa-mobile-alt"></i></span>
                            +91 9473039252
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="contact-inner two">
                    <h1 class="con-h1">Have Any Query?</h1>
                    @if(Session::get('errors'))
                    <div class="alert alert-success">
                        {{ $errors }}  
                    </div>
                    @endif
                    <form class="form-group" action="{{ url('contact') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" id="name" placeholder="Full Name">
                        </div>
                        <div class="form-group">
                            
                            <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            
                            <input type="text" name="contact" class="form-control" id="contact" placeholder="Conatct No">
                        </div>
                        <div class="form-group">
                            
                            <textarea name="message" class="form-control" id="message" placeholder="Your Message"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-primary">Send Message</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div> 
</div>


@endsection
@section('javascript')

<script>
 
</script>
@endsection


