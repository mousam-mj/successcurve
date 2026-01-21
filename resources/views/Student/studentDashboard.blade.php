
@extends('layout')
@section('title')
Student Dashboard
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
            <?php $cl = 0;?>
            @if(Session::get('userClass'))
                <?php $cl = Session::get('userClass');?>
            @endif
            <div class="modal fade" id="classModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Select Your Class</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ url('changeUserClass') }}" method="post">
                                    @csrf
                            <div class="modal-body">
                                    <div class="form-group">
                                        <label class="ds-label" for="cls">Your Class</label>
                                        <select id="cls" name="cls" class="form-control">
                                            <option value="0" disabled>-- Select Class --</option>
                                        </select>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                                </form>
                        </div>
                    </div>
                </div>
            
            <div class=" dash-sec-box">
                
                <div class="d-it-b dbgg">
                    <div class="ditlft">
                        <img src="{{asset('imgs/icons/students.png')}}" alt="" class="ditimg">
                    </div>
                    <div class="ditrt">
                        <h3 class="dith3">{{ $cse }}</h3>
                        <a class="ditrp" href="{{ url('student\myCourses') }}">Courses Enrolled</a>
                    </div>
                </div>
                <div class="d-it-b dbgp">
                    <div class="ditlft">
                        <img src="{{asset('imgs/icons/courses.png')}}" alt="" class="ditimg">
                    </div>
                    <div class="ditrt">
                        <h3 class="dith3">{{ $cs }}+</h3>
                        <a class="ditrp" href="{{ url('courses') }}">Courses Available</a>
                    </div>
                </div>
                <div class="d-it-b dbgbp">
                    <div class="ditlft">
                        <img src="{{asset('imgs/icons/tests.png')}}" alt="" class="ditimg">
                    </div>
                    <div class="ditrt">
                        <h3 class="dith3">{{ $tsen }}</h3>
                        <p class="ditrp">Tests Attempted</p>
                    </div>
                </div>
                <div class="d-it-b dbgo">
                    <div class="ditlft">
                        <img src="{{asset('imgs/icons/classes.png')}}" alt="" class="ditimg">
                    </div>
                    <div class="ditrt">
                        <h3 class="dith3">{{ $tsts }}+</h3>
                        <a class="ditrp" href="{{ url('mock-test') }}">Tests Available</a>
                    </div>
                </div>
                                
            </div>
            <div class="mt-30"></div>
            <h2 class="titleh2">Recommended Courses</h2>
            
            <div class="c-list owl-carousel owl-theme" id="coursecaro">
            @foreach($courses as $product)
                
            <div class="item">
                    
                <a class="new-c-item " href="{{ url('course/'.$product->courseId.'/'.$product->courseURI)}}">
                    <div class="cn-in-left">
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
            <div class="mt-30"></div>
            <h2 class="titleh2">Recommended Tests</h2>
            
            <div class="c-list owl-carousel owl-theme" id="testcaro">
            @foreach($tests as $test)
                <div class="item">

                    <a class="new-c-item " href="{{ url('exam/test/'.$test->tId.'/'.$test->tURI)}}">
                        <div class="cn-in-left">
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
    </div>
     
</div>

@endsection

@section('javascript')
<script>
$('#coursecaro').owlCarousel({
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
                items:3
            },
            1300:{
                items: 4
            }
        }
    })
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
                items:3
            },
            1300:{
                items: 4
            }
        }
    })
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
            $("#cls").append(bodyData);
        }
    });
    
     $(window).on('load', function() {
        
         var cl = <?php echo $cl;?>;
        if(cl == 0){
            console.log(cl);
            $('#classModal').modal('show');
        }
         
    });
    
</script>
@endsection
