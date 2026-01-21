 
@extends('layout')
@section('title')
Mock Test 
@endsection
@section('content')
<div class="main-box"> 
    <div class="ctsbox">
    
        <div class="ctxr mt-100">
            <div class="catogery-box">
                
        
        <h4 class="heading-text">
            {{ !empty($class) ? $class->className : "" }} {{ ($subject != null) ? $subject->subjectName : "" }} Tests 
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

        <div class="text-center m-4">
           {{ $tests->links() }}
        </div>
       
    </div>
        </div>
    </div>    
</div>

@endsection
@section('javascript')

@endsection