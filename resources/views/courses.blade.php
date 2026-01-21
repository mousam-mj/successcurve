 
@extends('layout')
@section('title')
Courses
@endsection
@section('content')
<div class="main-box">
    <div class="catogery-box mt-100" style="padding-left:30px; padding-right:30px;">
        <h4 class="heading-text mt-50">Courses List</h4>
        <div class="cn-listmain mt-5">
             
            @foreach($courses as $course)

            <div class="cn-list-item">
                <a href="{{ url('course/'.$course->courseId.'/'.$course->courseURI)}}" class="new-c-item">
                    <div class="cn-in-left">
                        @if ($course->coursePrice > 0)
                            <span class="badge-main badge-paid">₹ {{ $course->coursePrice }}</span>
                        @else
                            <span class="badge-main badge-free">Free</span>
                        @endif
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