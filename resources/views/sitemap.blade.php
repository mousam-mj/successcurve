 
@extends('layout')
@section('title')
Search
@endsection
@section('content')
<div class="main-box">
    <div class="catogery-box" style="min-height: 100vh;">
        @foreach($cls as $cl)
        <h4 class="heading-text mt-50">{{$cl->className}}</h4>
        <h5 class="text-left text-info">Courses</h5>
        <div class="c-list3">
            @foreach($crs as $cr)
                @if($cr->courseClass == $cl->classId)
                <a class="c-link2" href="{{ url('course/'.$cr->courseId.'/'.str_replace(' ', '-', $cr->courseTitle))}}">
                    {{ $cr->courseTitle }}
                </a>
                @endif
               
            @endforeach            
        </div>
        <h5 class="text-left text-info">Tests</h5>
        <div class="c-list3">
            @foreach($tests as $test)
                @if($test->tClass == $cl->classId)
                <a class="c-link2" href="{{ url('exam/test/'.$test->tId.'/'.str_replace(' ', '-', $test->tName))}}">
                    {{ $test->tName }}
                </a>
                @endif
               
            @endforeach            
        </div>
        
        @endforeach
    </div>    
</div>