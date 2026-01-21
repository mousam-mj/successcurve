
@extends('layout')
@section('title')
Edit Profile Image
@endsection
@section('content')

<div class="main-box">
    <div  class="row">
        <div class="col-md-3 col-12 s-menu">
            <div class="s-dash">
                <div class="d-img">
                    <img src= "{{ URL::asset(Session::get('fuserImage')) }}" alt="{{Session::get('fuserImage')}}" class="ds-img">
                </div>
                  <div class="s-cont">
                    <h3 class="ds-name">{{Session::get('fuser')}} </h3>
                      <p class="ds-p">{{Session::get('fuserEmail')}}</p>
                  </div>
              </div>
            @include('Faculty.sidebar')
        </div>
        
<!--        Dash-Container Starts   -->
        <div class="col-md-9 col-12 dash-container">
            
            
<!--            Error Box       -->
            @if(Session::get('errors'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>{{ $errors }}!</strong> 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @endif
            @if(Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>{{ Session::get('success') }}!</strong> 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @endif
            <div class="dash-header">
                <h3 class="dash-header-title">Upload Profile Image</h3>
            </div>
            
            <form action="{{URL('faculty/uploadImage')}}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="form-group">
                    <label for="image" class="ds-label"><i class="far fa-image"></i> Image</label>
                    <input type="file" class="form-control" name="image" id="image" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-custom3 form-control">Upload Image</button>
                </div>
            </form>
                   
      <!--        Container End   -->  
        </div>
        
        
        
        
    </div>
    
</div>
@endsection

@section('javascript')
<script>
$(document).ready(function(){
     
});
</script>

@endsection