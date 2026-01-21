@extends('layout')

@section('meta')
    <meta name="description" content=" {{ $products->courseMetaDesc }} ">
    <meta name="keywords" content="{{ $products->courseMetaKey }}">
    <meta name="author" content="{{ $products->courseTitle }}">
    <meta name=”robots” content=”index, follow”>
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $products->courseTitle }}" />
    <meta property="og:description" content="{{ $products->courseMetaDesc }}" />
    <meta property="og:image" content="{{ $products->courseThumbnail }}" />
    <meta property="og:url" content="{{ url('course/'.$products->courseId.'/'.$products->courseURI)}}" />
    <meta property="og:site_name" content="Successcurve.In" />
@endsection

@section('title')
Course Details
@endsection
@section('content')
<div class="main-box2">
    <div class="container mt-70">
        <div class="row">
            <div class="col-md-8 cd-main">
                
                <h3 class="dash-header-title2">{{!empty($products->courseTitle) ? $products->courseTitle:'Name'}}</h3>
                <div class="row">
                    <div class="col-md-2 col-sm-6">
                        <p class="course-sb"><i class="fas fa-book cicon"></i> {{$products->subjectName}}</p>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <p class="course-sb"><i class="fas fa-clipboard cicon"></i> {{$products->className}}</p>
                    </div>
                </div>
                <div class="course-description">
                    {!! $products->courseDescription !!}
                </div>
                
                
                <h5 class="course-content-title mt-30">Course Content</h5>
                <?php $count=1;?>
                @foreach($weeks as $week)
                
                <div class="accordion" id="accordionExample">
                  <div class="card m-card">
                    <div class="card-header m-header" id="headingOne<?php echo $count;?>">
                      <h2 class="mb-0">
                        <button class="btn btn-link text-white" type="button" data-toggle="collapse" data-target="#collapseOne<?php echo $count;?>" aria-expanded="true" aria-controls="collapseOne<?php echo $count;?>">
                          {{$week->weekName}}
                        </button>
                      </h2>
                    </div>

                    <div id="collapseOne<?php echo $count;?>" class="collapse" aria-labelledby="headingOne<?php echo $count;?>" data-parent="#accordionExample">
                      <div class="card-body">
                        <ul>
                            @foreach($lectures as $lecture)
                                @if($lecture->weekId == $week->weekId)
                                <li class="l-li"><a class="l-a">{{ $lecture->lectureTitle}}</a></li>
                                @endif
                            @endforeach
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
               
                <?php $count++; ?>
                @endforeach
                
            </div>
            <div class="col-md-4">
                <div class="cd-img-box">
                    <img class="cd-image" src="{{ URL::asset($products->courseThumbnail)}}">
                </div>
                
                <div class="text-center mt-20" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px; padding: 20px;">
                    @if ($enrolls == 0 && $products->coursePrice != null && $products->coursePrice > 0)
                        
                        <h3 class="text-success">
                            <b>RS. </b> {{$products->coursePrice}}/-
                        </h3>
                    @endif

                    <center class="mt-20">
                        
                        @if($enrolls == 1)
                            
                            <a href="{{url('goToCourse')}}/?courseId={{$products->courseId}}" class="btn btn-custom3 form-control">Go To Course</a>
                            <?php $printed = true;?>
                        @else
                            @if ($products->coursePrice != null && $products->coursePrice > 0)
                                <form action="{{ url('purchaseCourse') }}" method="get">
                                    <div class="modal-body">
                                        <input type="hidden" name="courseId" id="courseId" value="{{ $products->courseId }}">
                                        <div class="form-group">
                                            <label for="couponCode" class="text-success">Have a coupon code?</label>
                                            <input type="text" class="form-control" name="couponCode" id="copuponCode" placeholder="Enter Coupon Code">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-custom3 form-control">Purchase Course</button>
                                </form>
                            @else
                                <a href="{{url('enrollCourse')}}/?courseId={{$products->courseId}}" class="btn btn-custom3 form-control">Enroll Course</a>
                            @endif
                        @endif
                    </center>
                </div>
                <div class="instructor-box mt-30">
                    <p class="course-ins "><img src="{{ URL::asset($products->instructorImage) }}" alt="" class="ins-image"> {{$products->name}}</p>
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
<!--        Advertisment    -->
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