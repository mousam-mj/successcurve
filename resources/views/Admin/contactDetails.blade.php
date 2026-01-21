
@extends('layout')
@section('title')
Contact Details
@endsection
@section('content')
<div class="main-box">
    <div  class="row">
        <div class="col-md-3 col-12 s-menu">
            
            <div class="s-dash">
                <div class="d-img">
                    <img src= "{{ URL::asset(Session::get('auserImage')) }}" alt="{{Session::get('auserImage')}}" class="ds-img">
                </div>
                  <div class="s-cont">
                    <h3 class="ds-name">{{Session::get('auser')}} </h3>
                      <p class="ds-p">{{Session::get('auserEmail')}}</p>
                  </div>
              </div> 
            @include('Admin.adminSidebar')
        </div>
        
        <div class="col-md-9 col-12 dash-container">
                        
            <div class="card">
              <div class="card-header">
                <h3 class="card-title" style="float: left;"> Contact Details</h3>

                <div class="card-tools" style="float: right;">
                    
                </div>
              </div>
              <div class="card-body">
                <h3>From : {{ $cs->name }}</h3>
                  <p class="text-muted">At: {{ $cs->created_at }}</p>
                  
                  <p class="mt-30">{{ $cs->message }}</p>
                  
                  <h6>Email : {{ $cs->email }}</h6>
                  <h6>Contact No : {{ $cs->contact }}</h6>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                
              </div>
              <!-- /.card-footer-->
            </div>
            
            
        </div>
        
        
        
        
    </div>
    
</div>

@endsection

@section('javascript')
<script>
  
</script>
@endsection
