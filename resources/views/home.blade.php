
@extends('homelayout')
@section('title')
Home
@endsection


@section('content')

<div class="main-box">
<!--    Image Slider    -->

    <div id="carouselExampleIndicators" class="carousel slide mt-70" data-ride="carousel">
      <ol class="carousel-indicators">
          <?php $s = 0;?>
          @foreach($sliders as $slider)
            @if($s == 0)
            <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo  $s; ?>" class="active"></li>
            @else
          <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo  $s; ?>" class=""></li>
            @endif
          <?php $s++; ?>
          @endforeach
      </ol>
      <div class="carousel-inner">
          <?php $s1 = 0;?>
          @foreach($sliders as $slider)
           @if($s1 == 0)
            <div class="carousel-item active">
              <img src="{{ URL::asset($slider->image) }}" alt="{{$slider->name}}">
                <div class="carousel-caption text-left">
                    <div class="mb-20"></div>
                    <a href="@if($slider->url != null){{ url($slider->url) }}@else {{'#'}} @endif" class="btn btn-outline-1 animate__animated animate__fadeInUp sbtn">Get Started <i class="fas fa-caret-down c-ic2 "></i></a>
                </div>
            </div>
          @else
            <div class="carousel-item ">
                <img src="{{ URL::asset($slider->image) }}" alt="{{$slider->name}}">
                <div class="carousel-caption">
                    <div class="mb-20"></div>
                    <a href="@if($slider->url != null){{ url($slider->url) }}@else {{'#'}} @endif" class="btn btn-outline-1 animate__animated animate__fadeInUp ">Get Started <i class="fas fa-caret-down c-ic2 "></i></a>
                </div>
            </div>

          @endif
            <?php $s1++; ?>
          @endforeach
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>


<!--    Search Box  Start-->

    <div class="search-box text-center">
        <h1 class="search-title"><span class="h1-bold">Search</span> <span class="h1-regular">Courses</span></h1>
        <form action="{{url('search')}}" method="post">
            @csrf
            <div class="input-group mb-3 mt-30">
                <input type="text" class="form-control" placeholder="Search a Course" aria-label="Search a Course" aria-describedby="button-addon2" name="name">
                <select name="sc" id="sc" class="form-control search-cl">
                        <option value="">Select Class</option>
                    </select>
                <div class="input-group-append">

                    <button class="btn btn-secondary dark-btn" type="submit" id="button-addon2"><i class="fas fa-search"></i> <span class="mob-hide"><b>Search</b></span></button>
                </div>
            </div>
        </form>
        <div class="search-cont mt-30">
            <div class="cont-item">
                <div class="item-icon">
                    <i class="fas fa-book si"></i>
                </div>
                <div class="item-ct">
                    <h3 class="sct-h3">10+</h3>
                    <h6 class="sct-h6">Courses</h6>
                </div>
            </div>
            <div class="cont-item">
                <div class="item-icon">
                    <i class="fas fa-clipboard-list si"></i>
                </div>
                <div class="item-ct">
                    <h3 class="sct-h3">100+</h3>
                    <h6 class="sct-h6">Mock Tests</h6>
                </div>
            </div>
            <div class="cont-item">
                <div class="item-icon">
                    <i class="fas fa-users si"></i>
                </div>
                <div class="item-ct">
                    <h3 class="sct-h3">1000+</h3>
                    <h6 class="sct-h6">Learners</h6>
                </div>
            </div>
        </div>
    </div>
<!--    End Of Search Box   -->

<!--    Start of course by subject Section   -->
    <div class="catogery-box">
        <h4 class="title011">Explore Content By Class</h4>

        <div class="cls-list mt-50">

            <a href="{{ url('exploreByClass/5/Class-05')}}" class="cls-anc">
                <div class="cls-box">
                    <span class="cls-n">5</span>
                    <span class="cls-st">th</span>
                </div>
            </a>
            <a href="{{ url('exploreByClass/6/Class-06')}}" class="cls-anc">
            <div class="cls-box">
                <span class="cls-n">6</span>
                <span class="cls-st">th</span>
            </div>
            </a>
            <a href="{{ url('exploreByClass/7/Class-07')}}" class="cls-anc">
            <div class="cls-box">
                <span class="cls-n">7</span>
                <span class="cls-st">th</span>
            </div>
            </a>
            <a href="{{ url('exploreByClass/8/Class-08')}}" class="cls-anc">
            <div class="cls-box">
                <span class="cls-n">8</span>
                <span class="cls-st">th</span>
            </div>
            </a>
            <a href="{{ url('exploreByClass/1/Class-09')}}" class="cls-anc">
            <div class="cls-box">
                <span class="cls-n">9</span>
                <span class="cls-st">th</span>
            </div>
            </a>
            <a href="{{ url('exploreByClass/2/Class-10')}}" class="cls-anc">
            <div class="cls-box">
                <span class="cls-n">10</span>
                <span class="cls-st">th</span>
            </div>
            </a>
            <a href="{{ url('exploreByClass/3/Class-11')}}" class="cls-anc">
            <div class="cls-box">
                <span class="cls-n">11</span>
                <span class="cls-st">th</span>
            </div>
            </a>
            <a href="{{ url('exploreByClass/4/Class-12')}}" class="cls-anc">
            <div class="cls-box">
                <span class="cls-n">12</span>
                <span class="cls-st">th</span>
            </div>
            </a>
            <a href="{{ url('exploreByClass/9/UG')}}" class="cls-anc">
            <div class="cls-box">
                <span class="cls-n">UG</span>
            </div>
            </a>
            <a href="{{ url('exploreByClass/10/PG')}}" class="cls-anc">
            <div class="cls-box">
                <span class="cls-n">PG</span>
            </div>
            </a>
        </div>
        <center>
            <h3 class="cls-h3 mt-50">Take a closer look at the features of Successcurve and supplement your learning with more than 5 subjects for each class and varieties of tests created by our expert and dedicated teachers.</h3>
        </center>
    </div>
<!--    End Of Course by subject Box     -->

<!--    Start of Course by Class Section   -->
    <div class="catogery-box-pr">

        <h4 class="title012">Explore Content by Subject</h4>
        <div class="c-list owl-carousel owl-theme" id="cs">
            @foreach($products as $product)
            <a class="c-link" href="{{ url('exploreBySubject/'.$product->subjectId.'/'.str_replace(' ', '-', $product->subjectName))}}">
                <div class="c-items">
                    <img class="c-thumbnail" src="{{ URL::asset($product->thumbnail) }}" alt="{{ URL::asset($product->thumbnail) }}">
                </div>
            </a>
            @endforeach

        </div>
    </div>
<!--    End Of of Course by Class Section    -->

<!--    Start of Course by Subject Section   -->
    <div class="catogery-box">
        <h4 class="heading-text">Featured Courses</h4>
        <div class="c-list owl-carousel owl-theme" id="caro1">
            @foreach($courses as $product)
                <div class="item">
                    
                    <a class="new-c-item " href="{{ url('course/'.$product->courseId.'/'.$product->courseURI)}}">
                        <div class="cn-in-left">
                            @if ($product->coursePrice > 0)
                                <span class="badge-main badge-paid">₹ {{ $product->coursePrice }}</span>
                            @else
                                <span class="badge-main badge-free">Free</span>
                            @endif
                            <img src="{{ asset($product->courseThumbnail) }}" alt="Course Image">
                        </div>
                        <div class="cn-in-right">
                            <h5 class="cnh5" title="{{ $product->courseTitle }}">{{ substr($product->courseTitle, 0, 60)}}..</h5>
                            <p class="cnp">
                                <span class="cnp-sl">
                                     {{$product->subjectName}}
                                </span>
                                <span class="cnp-sr">
                                     
                                    @if($product->className == "Under Graduate")
                                        {{ 'UG' }}
                                    @else
                                        {{$product->className}}
                                    @endif
                                </span>
                            </p>
                        </div>
                    </a>
                    
                </div>
            @endforeach

        </div>

        

    </div>
<!--    End Of Course by Subject Section    -->
<!--    Start of Test by Subject Section   -->
    <div class="catogery-box">
        <h4 class="heading-text">Featured Tests</h4>
        <div class="c-list owl-carousel owl-theme" id="testcaro">
            @foreach($tests as $test)
                <div class="item">

                    <a class="new-c-item " href="{{ url('exam/test/'.$test->tId.'/'.$test->tURI)}}">
                        <div class="cn-in-left">
                            @if ($test->tPrice > 0)
                                <span class="badge-main badge-paid">₹ {{ $test->tPrice }}</span>
                            @else
                                <span class="badge-main badge-free">Free</span>
                            @endif
                            <img src="{{ asset($test->tImage) }}" alt="">
                        </div>
                        <div class="cn-in-right">
                            <h5 class="cnh5" title="{{$test->tName}}">{{substr($test->tName,0,60)}}..</h5>
                            <p class="cnp">
                                <span class="cnp-sl">
                                     {{$test->subjectName}}
                                </span>
                                <span class="cnp-sr">
                                    @if($test->className == "Under Graduate")
                                        {{ 'UG' }}
                                    @else
                                        {{$test->className}}
                                    @endif
                                </span>
                            </p>
                        </div>
                    </a>

                </div>
            @endforeach

        </div>
    </div>
<!--    End Of test by Subject Section    -->
  <!--    Start of TestSeries by Subject Section   -->
    <div class="catogery-box">
        <h4 class="heading-text">Featured Test Series</h4>
        <div class="c-list owl-carousel owl-theme" id="seriescaro">
            @foreach($series as $st)
                <div class="item mt-30">
                    <a href="{{ url('testSeriesDetails/'.$st->tcId)}}" class="ts-new-item two">
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
                </div>
            @endforeach

        </div>
    </div>
<!--    End Of testSeries by Subject Section    -->

<!--    Main Box End    -->
</div>

@endsection
@section('javascript')

<script>
$(document).ready(function(){
        $('#cs').owlCarousel({
        loop:true,
        margin:10,
        nav: true,
        navText:["<div class='nav-btn prev-slide'></div>","<div class='nav-btn next-slide'></div>"],
        dots:false,
        autoplay:true,
        autoplayTimeout:5000,
        autoplayHoverPause:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
                items:4
            },
            1280:{
                items: 5
            },
            1400:{
                items:6
            }
        }
    });
    $('#caro1').owlCarousel({
        loop:true,
        margin:10,
        nav: true,

        autoplay:true,
        autoplayTimeout:5000,
        autoplayHoverPause:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
                items:4
            },
            1400:{
                items:5
            }
        }
    });
        $('#testcaro').owlCarousel({
        loop:true,
        margin:10,
        nav: true,

        autoplay:true,
        autoplayTimeout:5000,
        autoplayHoverPause:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
                items:4
            }, 1400:{
                items:5
            }
        }
    });
        $('#seriescaro').owlCarousel({
        loop:true,
        margin:10,
        nav: true,

        autoplay:true,
        autoplayTimeout:5000,
        autoplayHoverPause:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
                items:4
            },
            1400:{
                items:5
            }
        }
    });

    $.ajax({
        url: "{{ URL('getClasses')}}",
        type: "POST",
        data:{
            _token:'{{ csrf_token() }}'
        },
        cache: false,
        dataType: 'json',
        success: function(dataResult){
            console.log(dataResult);
            var resultData = dataResult.data;
            var bodyData = '';
            $.each(resultData,function(index,row){
                bodyData+="<option value="+ row.classId +">"+ row.className +"</option>";

            })
            $("#sc").append(bodyData);
        }
    });

});


</script>
@endsection

