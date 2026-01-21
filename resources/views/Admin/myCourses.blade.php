
@extends('layout')
@section('title')
My Courses
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
            
            @if(Session::get('errors'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>{{ $errors }}!</strong> 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @endif
            <div class="c-list">
                @foreach($courses as $product)
                <div class="c-link">
                    <div class="course-div">
                        
                        <div class="course-image-box">
                            <img class="course-image" src="{{ URL::asset($product->courseThumbnail) }}" alt="{{ URL::asset($product->courseThumbnail) }}">
                        </div>
                        <div class="course-box pb-0">
                        <h6 class="course-title">{{$product->courseTitle}}</h6>
                            <p class="course-ins mt-20"><img src="{{ URL::asset($product->instructorImage) }}" alt="" class="ins-image"> {{$product->name}}</p>
                            
                            
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <p class="course-sb"><i class="fas fa-book cicon"></i> {{$product->subjectName}}</p>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <p class="course-sb"><i class="fas fa-clipboard cicon"></i> {{$product->className}}</p>
                            </div>
                            <div class="col-sm-12">
                                <p class="course-sb">
                                    <i class="fas fa-exclamation-circle"></i> 
                                    Status: 
                                    @if($product->courseStatus == 'Published')
                                    <span class="text-success">{{$product->courseStatus}}</span>
                                    @elseif($product->courseStatus == 'Pending')
                                    <span class="text-primary">{{$product->courseStatus}}</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <a class="text-center text-danger" href="{{ url('admin/removeCourse')}}/?courseId={{$product->courseId}}">
                                    <i class="fas fa-trash-alt"></i> Remove
                                </a>
                            </div>
                            <div class="col-md-6">                               
                                <a class="text-center text-primary" href="{{ url('admin/editCourses')}}/?courseId={{$product->courseId}}">
                                    <i class="fas fa-edit"></i> Edit
                                </a>                                
                            </div>
                        </div>
                    </div>
                    </div>

                </div>
                @endforeach

            </div>
       
        
        
        </div>
        
        
        
        
    </div>
    
</div>


