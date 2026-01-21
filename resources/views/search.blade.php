 
@extends('layout')
@section('title')
Search
@endsection
@section('content')
<div class="main-box">
    <div class="catogery-box">
        
        
        <h4>Showing Result For : "<small class="text-primary"> @if($st) {{ $st }} @endif</small>"</h4>
<!--        <h6>Courses Found: <span class="text-primary"> </span></h6>-->
        
        <h4 class="heading-text mt-50">Courses found @if($counts) {{ $counts }} @endif</h4>
        <div class="c-list2">
            
            
            
        <?php $count = 0;?>
            @foreach($products as $product)
            <a class="c-link" href="{{ url('course/'.$product->courseId.'/'.str_replace(' ', '-', $product->courseTitle))}}">
                <div class="course-div2">
                    <div class="course-image-box">
                        <img class="course-image" src="{{ URL::asset($product->courseThumbnail) }}" alt="{{ URL::asset($product->courseThumbnail) }}">
                    </div>
                    <div class="course-box">
                    <h6 class="course-title">{{$product->courseTitle}}</h6>
                        <p class="course-ins mt-20"><img src="{{ URL::asset($product->instructorImage) }}" alt="" class="ins-image"> {{$product->name}}</p>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <p class="course-sb"><i class="fas fa-book cicon"></i> {{$product->subjectName}}</p>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <p class="course-sb"><i class="fas fa-clipboard cicon"></i> {{$product->className}}</p>
                        </div>
                        <div class="col-md-12">
                            <input type="hidden" value="{{$product->courseId}}" id="courseId">
                            <button class="btn btn-custom3 form-control" id="enroll{{$product->courseId}}">About Course</button>
                        </div>
                        
                    </div>
                </div>
                </div>
                
            </a>
            <?php $count++;?>
            @endforeach
        @if(!$count > 0)
            <h4>No Results Founds</h4>
        @endif
        </div>
        
         <h4 class="heading-text mt-50">Tests found @if($counts) {{ $testcounts }} @endif</h4>
        <div class="c-list2">
            
            @foreach($tests as $test)
                <div class="item">
                    <a class="c-link" href="{{ url('exam/test/'.$test->tId.'/'.str_replace(' ', '-', $test->tName))}}">
                        <div class="course-div2">
                            <div class="course-image-box">
                                <img class="course-image" src="{{ URL::asset($test->tImage) }}" alt="{{ URL::asset($test->tImage) }}">
                            </div>
                            <div class="course-box">
                                <h6 class="course-title">{{$test->tName}}</h6>
                                    <p class="course-ins"><img src="{{ URL::asset($test->instructorImage) }}" alt="" class="ins-image"> {{$test->name}}</p>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <p class="course-sb"><i class="fas fa-book cicon"></i> {{$test->subjectName}}</p>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <p class="course-sb"><i class="fas fa-clipboard cicon"></i> {{$test->className}}</p>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-custom3 form-control" > About Test</button>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </a>
                </div>
            @endforeach
            @if(!$testcounts > 0)
            <h4>No Results Founds</h4>
            @endif
        </div>
         <h4 class="heading-text mt-50">Test Series found @if($seriescounts) {{ $testcounts }} @endif</h4>
        <div class="c-list2">
            
           @foreach($series as $st)
                <div class="item">
                    <div class="course-div2">
                        <div class="course-image-box">
                            <img class="course-image" src="{{ URL::asset($st->tcImage) }}" alt="{{ URL::asset($st->tcImage) }}">
                        </div>
                        <div class="course-box">
                            <h6 class="course-title">{{$st->tcName}}</h6>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <p class="course-sb"><i class="far fa-users-class cicon"></i> {{$st->className}}</p>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <p class="course-sb"><i class="fas fa-clipboard cicon"></i> {{$st->noOfTests}} Tests</p>
                                </div>
                                <div class="col-md-12">
                                    @if($st->tcType == 1)
                                        <p class="course-sb"><i class="far fa-rupee-sign cicon"></i> {{$st->tcFees}}</p>
                                    @endif
                                </div>
                                <div class="col-md-12">
                                    @if($st->tcType ==  0)
                                    <a class="btn btn-custom3 form-control" href="{{ url('testSeriesDetails/'.$st->tcId)}}"> Join Test Series</a>
                                    @elseif($st->tcType == 1)
                                        <a class="btn btn-custom3 form-control" href="{{ url('testSeriesDetails/'.$st->tcId)}}"> Buy Test Series</a>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @if(!$seriescounts > 0)
            <h4>No Results Founds</h4>
            @endif
        </div>
    </div>    
</div>