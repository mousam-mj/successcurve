
@extends('layout')
@section('title')
{{ $title }}
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
                <h3 class="dash-header-title">{{ $title }}</h3>
            </div>
            <div class="dash-form-box">
                <form action="{{URL('admin/sliders/add')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <input type="hidden" name="id" value="@if($slider != null){{ $slider->id }}@endif">

                    <div class="form-group">
                        <label for="name" class="ds-label"><i class="fas fa-user"></i>Slider Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="@if($slider != null){{ $slider->name }}@endif" required>
                    </div>
                    <div class="form-group">
                        <label for="url" class="ds-label"><i class="fas fa-user"></i>Slider URL</label>
                        <input type="text" class="form-control" name="url" id="url" value="@if($slider != null){{ $slider->url }}@endif" >
                    </div>
                    <div class="form-group">
                        <label for="image" class="ds-label"><i class="far fa-image"></i> Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                        @if($slider != null)
                        <p class="text-muted">
                            Previous Image: <img src="{{ asset($slider->image) }}" alt="" width="100">
                        </p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status" required>
                            <option value="1" <?php if($slider != null){ if($slider->status == 1){echo 'selected';}} ?>>Active</option>
                            <option value="0" <?php if($slider != null){ if($slider->status == 0){echo 'selected';}} ?>>Disable</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-custom3 form-control">
                            @if($status == 0)
                                Add Slider
                            @elseif($status == 1)
                                Update Slider
                            @endif
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        
        
        
    </div>
    
</div>


