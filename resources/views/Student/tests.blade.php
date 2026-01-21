
@extends('layout')
@section('title')
Enrolled Tests
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
                @foreach($tests as $test)
                    <div class="cn-list-item">
                        <a class="new-c-item" href="{{ url('exam/test/'.$test->tId.'/'.$test->tURI)}}">
                            <div class="cn-in-left">
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



