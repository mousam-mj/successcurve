 
@extends('layout')
@section('title')
Explore Successcurve 
@endsection
@section('content')
<div class="main-box"> 
    <div class="ctsbox">
    
        <div class="ctxr mt-100">

            <div class="catogery-box">
                
        
                <h4 class="heading-text">
                    {{ !empty($class) ? $class->className : "" }} {{ !empty($subject) ? $subject->subjectName : "" }} Courses 
                </h4>
                
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
                @if (count($courses) > 0) 
                    @if (!empty($class))
                        <div class="text-center m-4">
                            <a href="{{ url('explore/cls/courses/'.$class->classId) }}" class="btn btn-primary btn-sm">View All</a>
                        </div>
                    @elseif (!empty($subject)) 
                        <div class="text-center m-4">
                            <a href="{{ url('explore/sub/courses/'.$subject->subjectId) }}" class="btn btn-primary btn-sm">View All</a>
                        </div>
                    @endif
                @endif
            </div>
            <div class="catogery-box">
                
        
        <h4 class="heading-text">
            {{ !empty($class) ? $class->className : "" }} {{ !empty($subject) ? $subject->subjectName : "" }} Tests 
        </h4>
        
        <div class="cn-listmain mt-5">
            @foreach($tests as $test)
                <div class="cn-list-item">
                    <a class="new-c-item" href="{{ url('exam/test/'.$test->tId.'/'.$test->tURI)}}">
                        <div class="cn-in-left">
                            @if ($test->tPrice > 0)
                                <span class="badge-main badge-paid">₹ {{ $test->tPrice }}</span>
                            @else
                                <span class="badge-main badge-free">Free</span>
                            @endif
                            <img src="{{ URL::asset($test->tImage) }}" alt="">
                        </div>
                        <div class="cn-in-right">
                            <h5 class="cnh5" title="{{$test->tName}}">{{substr($test->tName,0,60)}}..</h5>
                            <div class="cnp">
                                <span class="cnp-sl">
                                    {{$test->subjectName}}
                                </span>
                                <span class="cnp-sr">
                                    @if($test->className == "Under Graduate")
                                        {{ 'UG' }}
                                    @elseif($test->className == "Post Graduate")
                                        {{ 'PG' }}
                                    @else
                                        {{$test->className}}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </a>
                
                </div>
               
            @endforeach

            
            
        </div> 
        @if (count($tests) > 0) 
            @if (!empty($class))
                <div class="text-center m-4">
                    <a href="{{ url('explore/cls/tests/'.$class->classId) }}" class="btn btn-primary btn-sm">View All</a>
                </div>
            @elseif (!empty($subject)) 
                <div class="text-center m-4">
                    <a href="{{ url('explore/sub/tests/'.$subject->subjectId) }}" class="btn btn-primary btn-sm">View All</a>
                </div>
            @endif
        @endif      
    </div>
    
    @if (!empty($class)) 
    <div class="catogery-box">
                
        
        <h4 class="heading-text">
            {{ !empty($class) ? $class->className : "" }} {{ !empty($subject) ? $subject->subjectName : "" }} Test Series 
        </h4>
        
        <div class="ts-new-wrapper">
            @foreach($testseries as $st)
                <a href="{{ url('testSeriesDetails/'.$st->tcId)}}" class="ts-new-item">
                    <div class="ts-new-box-left">
                        @if ($st->tcPrice > 0)
                            <span class="badge-main badge-paid">₹ {{ $st->tcPrice }}</span>
                        @else
                            <span class="badge-main badge-free">Free</span>
                        @endif
                        <img src="{{ asset($st->tcImage) }}" alt="Test Series Thumbnail" class="ts-new-thumbnail">
                    </div>
                    <div class="ts-new-box-right">
                        <h6 class="ts-new-box-h5">
                            {{$st->tcName}}
                        </h6>
                        <div class="cnp">
                            <span class="cnp-sl">
                                {{$st->className}}
                            </span>
                            <span class="cnp-sr">
                                {{$st->noOfTests}}+ Tests
                            </span>
                            
                        </div>
                    </div>
                </a>
            @endforeach
            
           
            
        </div>
        
        @if (count($testseries) > 0) 
            <div class="text-center m-4">
                <a href="{{ url('explore/cls/testSeries/'.$class->classId) }}" class="btn btn-primary btn-sm">View All</a>
            </div>
        @endif
       
    </div>
    @endif
        </div>
    </div>    
</div>

@endsection
@section('javascript')

@endsection