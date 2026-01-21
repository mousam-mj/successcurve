
@extends('layout')
@section('title')
My Test Series
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
            <div class="ts-new-wrapper">
                @foreach($tss as $st)
                    <a href="{{ url('testSeriesDetails/'.$st->tcId)}}" class="ts-new-item">
                        <div class="ts-new-box-left">
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
                                <span class="cnp-sl">
                                    Class 10
                                </span>
                                <span class="cnp-sr">
                                    Special
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
                
            </div>

            <div class="text-center m-4">
                {{ $tss->links() }}
            </div>
        </div>
    </div>
    
</div>



