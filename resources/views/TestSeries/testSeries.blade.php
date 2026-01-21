 
@extends('layout')
@section('title')
Test Series
@endsection
@section('content')
<div class="main-box mt-100"> 
    <div class="catogery-box">

        <h4 class="heading-text mt-50">Popular Test Series</h4>


        <div class="ts-new-wrapper">
            @foreach($pts as $st)

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
        
        @foreach($classes as $cl)
        <h4 class="heading-text mt-50">{{$cl['class']->className}} Test Series </h4>
        <div class="ts-new-wrapper">
            @foreach($cl['testSeries'] as $st)
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
            <a href="{{ url('testSeries/'.$cl['class']->classId) }}" class="btn btn-primary btn-sm">View All</a>
        </div>
        
        @endforeach
    </div>    
</div>