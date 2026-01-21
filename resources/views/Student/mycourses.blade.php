
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
                    <img src= "{{ URL::asset(Session::get('userImage')) }}" alt="{{Session::get('userImage')}}" class="ds-img">
                </div>
                  <div class="s-cont">
                    <h3 class="ds-name">{{Session::get('user')}} </h3>
                      <p class="ds-p">{{Session::get('userEmail')}}</p>
                  </div>
              </div>
            @include('Student.sidebar')
        </div>
        
        <div class="col-md-9 col-12 dash-container">

            <div class="cn-listmain mt-5">
             
                @foreach($courses as $course)
    
                <div class="cn-list-item">
                    <a href="{{ url('course/'.$course->courseId.'/'.$course->courseURI)}}" class="new-c-item">
                        <div class="cn-in-left">
                            <img src="{{ asset($course->courseThumbnail) }}" alt="Course Image">
                            <i class="fal fa-file-invoice cn-icon"></i>
                        </div>
                        <div class="cn-in-right">
                            <h5 class="cnh5" title="{{ $course->courseTitle }}">{{ substr($course->courseTitle, 0, 40)}}..</h5>
                            <p class="cnp">
                                <span class="cnp-sl">
                                    {{$course->subjectName}}
                                </span>
                                <span class="cnp-sr">
                                    {{$course->className}}
                                </span>
                            </p>
                        </div>
                    </a>
                </div>
                
                @endforeach
                
            </div>
            <div class="m-5">
                {{ $courses->links() }}
            </div>
            
        </div>
    </div>
    
</div>



