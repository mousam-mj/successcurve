
@extends('layout')
@section('title')
Qustion Uploader Dashboard
@endsection
@section('content')
 
<div class="main-box">
    <div  class="row">
        <div class="col-md-3 col-12 s-menu">
            
            <div class="s-dash">
                <div class="d-img">
                    <img src= "{{ URL::asset(Session::get('qaImage')) }}" alt="{{Session::get('qaImage')}}" class="ds-img">
                </div>
                  <div class="s-cont">
                    <h3 class="ds-name">{{Session::get('qaUser')}} </h3>
                      <p class="ds-p">{{Session::get('qaEmail')}}</p>
                  </div>
              </div>
            @include('qas.sidebar')
        </div>
        
        <div class="col-md-9 col-12 dash-container">
             
            @if(Session::get('errors'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>{{ $errors }}!</strong> 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @endif
            @if(Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>{{ Session::get('success') }}!</strong> 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @endif
            <div class=" dash-sec-box">
                
                <div class="d-it-b dbgg">
                    <div class="ditlft">
                        <img src="{{asset('imgs/icons/students.png')}}" alt="" class="ditimg">
                    </div>
                    <div class="ditrt">
                        <h3 class="dith3"><span id="students">{{ $sts }}</span>+</h3>
                        <p class="ditrp">Students</p>
                    </div>
                </div>
                <div class="d-it-b dbgp">
                    <div class="ditlft">
                        <img src="{{asset('imgs/icons/courses.png')}}" alt="" class="ditimg">
                    </div>
                    <div class="ditrt">
                        <h3 class="dith3"><span id="courses"> {{ $cs }}</span>+</h3>
                        <p class="ditrp">Courses</p>
                    </div>
                </div>
                <div class="d-it-b dbgbp">
                    <div class="ditlft">
                        <img src="{{asset('imgs/icons/tests.png')}}" alt="" class="ditimg">
                    </div>
                    <div class="ditrt">
                        <h3 class="dith3"><span id="tests"> {{ $tsts }}</span>+</h3>
                        <p class="ditrp">Tests</p>
                    </div>
                </div>
                <div class="d-it-b dbgo">
                    <div class="ditlft">
                        <img src="{{asset('imgs/icons/classes.png')}}" alt="" class="ditimg">
                    </div>
                    <div class="ditrt">
                        <h3 class="dith3"><span id="classes">{{ $cls }}</span>+</h3>
                        <p class="ditrp">Classes</p>
                    </div>
                </div>
                
                <div class="d-it-b dbgg">
                    <div class="ditlft">
                        <img src="{{asset('imgs/icons/subjects.svg')}}" alt="" class="ditimg"> 
                    </div>
                    <div class="ditrt">
                        <h3 class="dith3"><span id="subjects"> {{ $sbs }}</span>+</h3>
                        <p class="ditrp">Subjects</p>
                    </div>
                </div>
                <div class="d-it-b dbgp">
                    <div class="ditlft">
                        <img src="{{asset('imgs/icons/topics.png')}}" alt="" class="ditimg">
                    </div>
                    <div class="ditrt">
                        <h3 class="dith3"><span id="topics"> {{ $tps }}</span>+</h3>
                        <p class="ditrp">Topics</p>
                    </div>
                </div>
                <div class="d-it-b dbgbp">
                    <div class="ditlft">
                        <img src="{{asset('imgs/icons/questions.png')}}" alt="" class="ditimg">
                    </div>
                    <div class="ditrt">
                        <h3 class="dith3"><span id="questions"> {{ $qs }}</span>+</h3>
                        <p class="ditrp">Questions</p>
                    </div>
                </div>
                <div class="d-it-b dbgo">
                    <div class="ditlft">
                        <img src="{{asset('imgs/icons/testseries.png')}}" alt="" class="ditimg">
                    </div>
                    <div class="ditrt">
                        <h3 class="dith3"><span id="testseries"> {{ $tss }}</span>+</h3>
                        <p class="ditrp">Test Series</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-40"></div>
            <div class="row">
                <div class="col-md-6 col-md-offset-1">
                    <div class="panel panel-default">
                       <div class="panel-heading"><b>Trending Course</b></div>
                       <div class="panel-body">
                           <canvas id="coursegraph" height="280" width="600"></canvas>
                       </div>
                   </div>
                </div>
                <div class="col-md-6 col-md-offset-1">
                    <div class="panel panel-default">
                       <div class="panel-heading"><b>Trending Mock Test</b></div>
                       <div class="panel-body">
                           <canvas id="testgraph" height="280" width="600"></canvas>
                       </div>
                   </div>
                </div>
            </div>
        </div>
        
        
        
        
    </div>
    
</div>

@endsection

@section('javascript')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>



<script>
$(document).ready(function() {
    
   
    
    
    $.ajax({
        url: "{{ URL('qas/getAllCourses')}}",
        type: "POST",
        data:{ 
            _token:'{{ csrf_token() }}'
        },
        cache: false,
        dataType: 'json',
        success: function(dataResult){
//            console.log(dataResult);
            var resultData = dataResult.data;
            $("#courses").html(resultData);
        }
    }); 
//    $.ajax({
//        url: "{{ URL('qas/getPendingCourses')}}",
//        type: "POST",
//        data:{ 
//            _token:'{{ csrf_token() }}'
//        },
//        cache: false,
//        dataType: 'json',
//        success: function(dataResult){
////            console.log(dataResult);
//            var resultData = dataResult.data;
//            $("#penCourses").html(resultData);
//        }
//    });    
//    $.ajax({
//        url: "{{ URL('qas/getPublishedCourses')}}",
//        type: "POST",
//        data:{ 
//            _token:'{{ csrf_token() }}'
//        },
//        cache: false,
//        dataType: 'json',
//        success: function(dataResult){
////            console.log(dataResult);
//            var resultData = dataResult.data;
//            $("#pubCourses").html(resultData);
//        }
//    });
//    $.ajax({
//        url: "{{ URL('qas/getRemovedCourses')}}",
//        type: "POST",
//        data:{ 
//            _token:'{{ csrf_token() }}'
//        },
//        cache: false,
//        dataType: 'json',
//        success: function(dataResult){
//            console.log(dataResult);
//            var resultData = dataResult.data;
//            $("#delCourses").html(resultData);
//        }
//    });
//    
    var Course = new Array();
    var Labels = new Array();
    var Students = new Array();
    var url = "{{url('qas/getTopCourse')}}";
//    
//    $.ajax({
//            url: "{{ URL('qas/getTopCourse')}}",
//            type: "POST",
//            data:{ 
//                _token:'{{ csrf_token() }}',
//            },
//            cache: false,
//            dataType: 'json',
//            success: function(dataResult){
//                console.log(dataResult);
//                var resultData = dataResult.data;
//                var bodyData = '';
//                $.each(resultData,function(index,data){
//                    course.push(data.courseTitle);
//                    labels.push(data.courseTitle);
//                    students.push(data.students);
//                })
//            }
//        
//        ctx = document.getElementById("coursegraph").getContext('2d');
//         myChart = new Chart(ctx, {
//              type: 'bar',
//              data: {
//                  labels:course,
//                  datasets: [{
//                      label: 'Top Courses',
//                      data: students,
//                      borderWidth: 1
//                  }]
//              },
//              options: {
//                  scales: {
//                      yAxes: [{
//                          ticks: {
//                              beginAtZero:true
//                          }
//                      }]
//                  }
//            }
//        });
//    });
    
    $.get(url, function(response){
            response.forEach(function(data){
                Course.push(data.courseTitle);
                Labels.push(data.courseTitle);
                Students.push(data.students);
            });
            var ctx = document.getElementById("coursegraph").getContext('2d');
                var myChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                      labels:Course,
                      datasets: [{
                          label: 'Top Courses',
                          data: Students,
                          backgroundColor: [
                                'rgba(255, 99, 132, 0.8)',
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(255, 206, 86, 0.8)',
                                'rgba(75, 192, 192, 0.8)',
                                'rgba(153, 102, 255, 0.8)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)'
                            ],
                          borderWidth: 1
                      }]
                  },
                  options: {
                      scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero:true
                              }
                          }]
                      }
                  }
              });
          });
    var Tests = new Array();
    var TestLabels = new Array();
    var TestStudents = new Array();
    var url = "{{url('qas/getTopTests')}}";
    $.get(url, function(response){
            response.forEach(function(data){
                Tests.push(data.tName);
                TestLabels.push(data.tName);
                TestStudents.push(data.students);
            });
            var ctx = document.getElementById("testgraph").getContext('2d');
                var myChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                      labels:TestLabels,
                      datasets: [{
                          label: '',
                          data: TestStudents,
                          backgroundColor: [
                                'rgba(255, 99, 132, 0.8)',
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(255, 206, 86, 0.8)',
                                'rgba(75, 192, 192, 0.8)',
                                'rgba(153, 102, 255, 0.8)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)'
                            ],
                          borderWidth: 1
                      }]
                  },
                  options: {
                      scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero:true
                              }
                          }]
                      }
                  }
              });
          });
    
});
</script>
@endsection


