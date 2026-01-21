@extends('layout')

@section('meta')
    <meta name="description" content=" {{ $tests->tMetaDesc }} ">
    <meta name="keywords" content="{{ $tests->tMetaKey }}">
    <meta name="author" content="{{ $tests->tName }}">

    <meta name=”robots” content=”index, follow”>
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $tests->tName }}" />
    <meta property="og:description" content="{{ $tests->tMetaDesc }}" />
    <meta property="og:image" content="{{ $tests->tImage }}" />
    <meta property="og:url" content="{{ url('exam/test/'.$tests->tId.'/'.$tests->tURI)}}" />
    <meta property="og:site_name" content="Successcurve.In" />

@endsection

@section('title')
Exam Details
@endsection
@section('content')
<div class="main-box2">
    <div class="container mt-70">
        <div class="row">
            <div class="col-md-8 cd-main">
                <h3 class="dash-header-title2">{{!empty($tests->tName) ? $tests->tName:'Test Name'}}</h3>
                <div class="row">
                    <div class="col-md-2 col-sm-6">
                        <p class="course-sb"><i class="fas fa-book cicon"></i> {{$tests->subjectName}}</p>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <p class="course-sb"><i class="fas fa-clipboard cicon"></i> {{$tests->className}}</p>
                    </div> 
                </div>
                <div class="course-description">
                    {!! $tests->description !!}
                </div>
                
            </div>
            <div class="col-md-4">
                <div class="cd-img-box">
                    <img class="cd-image" src="{{ URL::asset($tests->tImage)}}">
                </div>

                <div class="text-center mt-20" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px; padding: 20px;">
                    @if ($enrolls == 0 && $tests->tPrice != null && $tests->tPrice > 0)
                        <h3 class="text-success">
                            <b>RS. </b> {{$tests->tPrice}}/-
                        </h3>
                    @endif

                    <center class="mt-20">
                    
                            @if($enrolls == 1)
                                <a href="
                                @if ($tests->start_date > Carbon\Carbon::now())
                                    javascript:void(0);
                                @else
                                    {{url('exam/testInstruction/'.$tests->tId)}}
                                @endif
                                " class="btn btn-custom3 form-control">Take Test</a>
                            
                            @elseif($enrolls == 0)
                                
                                @if ($tests->tPrice != null && $tests->tPrice > 0)
                                    <form action="{{ url('purchaseTest') }}" method="get">
                                        <div class="modal-body">
                                            <input type="hidden" name="testId" id="testId" value="{{ $tests->tId }}">
                                            <div class="form-group">
                                                <label for="couponCode" class="text-success">Have a coupon code?</label>
                                                <input type="text" class="form-control" name="couponCode" id="copuponCode" placeholder="Enter Coupon Code">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-custom3 form-control">Purchase Course</button>
                                    </form>
                                @else
                                    <a href="{{url('exam/enrollTest/'.$tests->tId)}}"  class="btn btn-custom3 form-control">Enroll Test</a>
                                @endif
                            @endif
                    </center>
                
                </div>
                <div class="instructor-box mt-30">
                    <p class="course-ins "><img src="{{ URL::asset($tests->instructorImage) }}" alt="" class="ins-image"> {{$tests->name}}</p>
                </div>
                
                
<!--                Advertisement           -->
                
                
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- Square Size Widget Ads -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-2316285054238175"
                     data-ad-slot="8237926052"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- Horizontal Ads -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-2316285054238175"
                     data-ad-slot="3282216760"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </div>
    </div>
        
        
</div>


@endsection

@section('javascript')

@endsection