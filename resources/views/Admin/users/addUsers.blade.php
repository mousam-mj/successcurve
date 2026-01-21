
@extends('layout')
@section('title')
Add User
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
            <div class="dash-header">
                <h3 class="dash-header-title">Add User</h3>
            </div>
            <div class="dash-form-box">
                <form action="{{URL('admin/users/addUser')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="form-group">
                        <label for="name" class="ds-label"><i class="fas fa-user"></i> Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="ds-label"><i class="fas fa-at"></i> Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="contact" class="ds-label"><i class="fas fa-mobile-alt"></i> Contact</label>
                        <input type="text" class="form-control" name="contact" id="contact" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="ds-label"><i class="fas fa-key"></i> Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="form-group">
                        <label for="image" class="ds-label"><i class="far fa-image"></i> Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                    </div>
                    <div class="form-group">
                        <label for="type" class="ds-label"><i class="far fa-image"></i> User Type</label>
                       <select class="form-control" name="type" id="type">
                           <option value="admin">Admin</option>
                           <option value="faculty">Instructor</option>
                           <option value="qas">QAs</option>
                           <option value="user">User</option>
                       </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-custom3 form-control">Add User</button>
                    </div>
                </form>
            </div>
        </div>
        
        
        
        
    </div>
    
</div>


