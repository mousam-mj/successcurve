
@extends('layout')
@section('title')
Edit Profile
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
        
<!--        Dash-Container Starts   -->
        <div class="col-md-9 col-12 dash-container">
            
            
<!--            Error Box       -->
            @if(Session::get('errors'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>{{ $errors['msg'] }}!</strong> 
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
                <h3 class="dash-header-title">Edit Profile</h3>
            </div>
            <div class="profile-image-box">
                <img src= "{{ URL::asset(Session::get('auserImage')) }}"  alt="Profile Image" class="profile-image">
                <a class="p-edit" href="{{url('admin/uploadImage')}}">
                        <i class="fas fa-edit pi text-center"></i> 
                </a>
            </div>
            <div class="dash-form-box">
                <h4 class="small-header">Personal Infromation</h4>
                <form action="{{URL('admin/editProfile')}}" method="post" class="mt-20">
                @csrf
                    <div class="form-group">
                        <label for="name" class="ds-label"><i class="fas fa-user"></i> Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ Session::get('auser')}}" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="ds-label"><i class="fas fa-at"></i> Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="{{ Session::get('auserEmail')}}" required>
                    </div>
                    <div class="form-group">
                        <label for="contact" class="ds-label"><i class="fas fa-phone-alt"></i> Contact No</label>
                        <input type="text" class="form-control" name="contact" id="contact" value="{{ Session::get('auserContact')}}" required>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-custom3 form-control">Change Personal Information</button>
                    </div>
                </form>
            </div>
            <div class="dash-form-box">
            <h4 class="small-header ">Change Password</h4>

                <form action="{{URL('admin/changePassword')}}" method="post" class="mt-20">
                @csrf
                    <div class="form-group">
                        <label for="cp" class="ds-label"><i class="fas fa-lock"></i> Current Password</label>
                        <input type="password" class="form-control" name="oldPass" id="cp" required>
                    </div>
                    <div class="form-group">
                        <label for="np" class="ds-label"><i class="fas fa-key"></i> New Password</label>
                        <input type="password" class="form-control" name="newPass" id="np" required>
                    </div>
                    <div class="form-group">
                        <label for="name" class="ds-label"><i class="fas fa-key"></i> Confirm New Password</label>
                        <input type="password" class="form-control" name="confPass" id="cnp" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-custom3 form-control">Change Password</button>
                    </div>
                </form>
            </div>        
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