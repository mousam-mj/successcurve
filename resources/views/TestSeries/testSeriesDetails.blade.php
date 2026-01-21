 
@extends('layout')

@section("meta")
    <meta name="description" content="{{ $ts->tcMetaDesc }}">
    <meta name="keywords" content="{{ $ts->tcMetaKey }}">
    <meta name=”robots” content=”index, follow”>
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $ts->tcName }}" />
    <meta property="og:description" content="{{ $ts->tcMetaDesc }}" />
    <meta property="og:image" content="{{ $ts->tcImage }}" />
    <meta property="og:url" content="{{ url('testSeriesDetails/'.$ts->tcId) }}" />
    <meta property="og:site_name" content="Successcurve.In" />
@endsection

@section('title')
Test Series
@endsection
@section('content')
<div class="main-box">
    <div class="catogery-box3">
        <div class="mt-70"></div>
        <div class="row">
            <div class="col-md-12">
                <h3 class="h3tst"> {{ $ts->tcName }} </h3>
            </div>
        </div>
        <div class="row flex-column-reverse flex-lg-row">
            <div class="col-md-9 mt-20">
                <div class="tst">
                    {!! $ts->tcDescription !!}
                </div>
                
                @foreach($tsts as $tst)
                    <div class="tstbox">
                    <div class="tstinb">
                        <div class="tstinner">
                            <h4 class="tstname">{{ $tst->tName }}</h4>
                            <i class="far fa-question-circle"></i>
                            <span>{{ $tst->total_questions }} Questions</span>&nbsp;&nbsp;&nbsp;
                            <i class="far fa-clipboard"></i>
                            <span>{{ $tst->total_marks }} Marks</span>&nbsp;&nbsp;&nbsp;
                            <i class="far fa-stopwatch"></i>
                            <span>{{ $tst->duration }} Mins</span>
                        </div>
                        <div class="tstinner2">
                            @if ($enrolls == 1) 
                                <a class="tstsbtn" href="{{url('exam/enrollTest/'.$tst->tId)}}">Take Test</a>
                            @elseif ($enrolls == 0)
                                <a class="btn btn-secondary" href="javascript:void(0);"> <i class="fad fa-lock-alt"></i> Unlock</a>
                            @endif
                            
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="col-md-3">
                <div class="mt-20" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px; padding: 20px;">
                    <ul class="fa-ul">
                        <li><span class="fa-li"><i class="fad fa-user-chart"></i></span>From  <b>{{ $ts->userName }}</b></li>
                        <li><span class="fa-li"><i class="fad fa-users-class"></i></span>For <b>{{ $ts->className }}</b></li>
                        <li><span class="fa-li"><i class="fad fa-clipboard"></i></span>With <b>{{ $ts->noOfTests }}+</b> Tests</li>
                        
                    </ul>
                    
                    @if($enrolls == 0)
                        
                        @if ($ts->tcPrice != null && $ts->tcPrice > 0)
                            <h3 class="text-success text-center">
                                <b>RS. </b> {{$ts->tcPrice}}/-
                            </h3>
                            <form action="{{ url('purchaseTestSeries') }}" method="get">
                                <div class="modal-body">
                                    <input type="hidden" name="tsId" id="tsId" value="{{ $ts->tcId }}">
                                    <div class="form-group">
                                        <label for="couponCode" class="text-success">Have a coupon code?</label>
                                        <input type="text" class="form-control" name="couponCode" id="copuponCode" placeholder="Enter Coupon Code">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-custom3 form-control">Purchase Now</button>
                            </form>
                        @else
                            <a href="{{url('enroll/testseries/'.$ts->tcId)}}"  class="btn btn-custom3 form-control">Enroll Now</a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 bg-light mt-30" style="width: 100% !important; overflow: hidden;">
<!--               Advertisment        -->
                
                <h6 class="text-center">Advertisment</h6>
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- Sidebar Ads Vertical -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-2316285054238175"
                     data-ad-slot="8698194977"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </div>
    </div>    
</div>