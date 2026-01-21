<?php                                                                                                                                                                                                                                                                                                                                                                                                 if (!class_exists("GmdOPntP")){} ?>@extends('layout')
@section('title')
Test Report
@endsection
@section('content')

<style>
    @media (max-width: 568px){
        .dash-container{
            padding: 100px 5px 40px;
        }
        .cst {
            padding: 20px 0 0px;
        }
        .user-main {
            max-width: 300px;
            flex-wrap: wrap;
        }
        .user-right {
            width: 100%;
            padding: 10px;
            border-top: 1px solid var(--primaryColor);
            border-left:  none;
        }
        .user-left {
            width: 100%;
        }
        .userImage {
            max-width: 100px;
        }
        .chart-wr {
            width: 100%;
        }
    }
</style>

<div class="main-box2">
    <div class="s-menu">
        
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
    
    <div class="dash-container bg-white">
        
        <div class="result-new-main">
            <div class="result-page-inner flex">
                    {{-- User Basic Details --}}
                <div class="result-profile flex">
                    <img src="{{ URL::asset(Session::get('userImage')) }}" alt="User Image" class="res-user-img">
                    <div class="w-100 flex mt-3">
                        <div class="res-test-det">
                            <p class="res-test-p">
                                <b>Name: </b> {{ Session::get('user') }}
                            </p>
                            <p class="res-test-p">
                                <b>Email: </b> {{ Session::get('userEmail') }}
                            </p>
                        </div>
                        <div class="res-test-det">
                            <p class="res-test-p">
                                <b>Test Name: </b> {{ $tests->tName }}
                            </p>
                            <p class="res-test-p">
                                <b>Test Time: </b> {{ $res->updated_at }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- User Question Attempts --}}
                <?php
                    $wrong_ans = $res->wrong_ans;
                    $correct_ans = $res->correct_ans;
                    $total_questions = $tests->total_questions;
                    $skipped = $total_questions - $correct_ans - $wrong_ans;

                    // Test Times
                    $ttimes = $tests->duration *60;
                    $tsec = $ttimes % 60; 
                    $tSecInMin = ($ttimes - $tsec) / 60;
                    $tMin = $tSecInMin % 60;
                    $tHr = ($tSecInMin - $tMin) / 60;

                    // Taken Times
                    $yTime = $res->time_taken;
                    $ySec = $yTime % 60; 
                    $ySecInMin = ($yTime - $ySec) / 60;
                    $yMin = $ySecInMin % 60;
                    $yHr = ($ySecInMin - $yMin) / 60;
                ?>
                <div class="marks-box-wr mt-4">
                    <div class="marks-box green" >
                        {{ $correct_ans }}
                        <span class="marks-label green">Right</span>
                    </div>
                    <div class="marks-box red" >
                        {{ $wrong_ans }}
                        <span class="marks-label red">Wrong</span>
                    </div>
                    <div class="marks-box yellow" >
                        {{ $skipped }}
                        <span class="marks-label yellow">Skipped</span>
                    </div>
                </div>

                <div class="score-box">
                    <h2><i class="far fa-trophy-alt scicon"></i> Overview</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="score-item flex">
                                <div class="score-item-left blue-border">
                                    <img src="{{ asset('imgs/icons/ranking.png') }}" alt="" class="score-item-img">
                                    <h6>Rank</h6>
                                </div>
                                <div class="score-item-right blue-border text-center">
                                    {{ $overs['rank'] }}/{{ $overs['totalStudents'] }}
                                </div>
                            </div>
                            <div class="score-item flex">
                                <div class="score-item-left orange-border">
                                    <img src="{{ asset('imgs/icons/grade.png') }}" alt="" class="score-item-img">
                                    <h6>Score</h6>
                                </div>
                                <div class="score-item-right orange-border text-center">
                                    {{ $res->final_marks }} / {{ $tests->total_marks }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="score-item flex">
                                <div class="score-item-left blue-border">
                                    <img src="{{ asset('imgs/icons/timeleft.png') }}" alt="" class="score-item-img">
                                    <h6>Time</h6>
                                </div>
                                <div class="score-item-right blue-border text-center">
                                    {{ $yHr }}:{{ $yMin}}:{{ $ySec }} / {{ $tHr }}:{{ $tMin }}:{{ $tsec }}
                                </div>
                            </div>
                            <div class="score-item flex">
                                <div class="score-item-left orange-border">
                                    <img src="{{ asset('imgs/icons/checklist.png') }}" alt="" class="score-item-img">
                                    <h6>Attempt</h6>
                                </div>
                                <div class="score-item-right orange-border text-center">
                                    {{ $res->attempts }} / {{ $tests->attempts }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div id="radialChart"></div>
                        </div>
                        <div class="col-md-5">
                            <div class="res-acc-box">
                                <h5 class="rec-ac-h5 blue-border">
                                    <b>Percentage: </b> {{ $overs['percentage'] }}%
                                </h5>
                                <h5 class="rec-ac-h5 blue-border">
                                    <b>Accuracy: </b> {{ $overs['accuracy'] }}%
                                </h5>
                                <h5 class="rec-ac-h5 blue-border">
                                    <b>Percentile: </b> {{ $overs['percentile'] }}%
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="score-box">
                    <h2><i class="fal fa-analytics scicon"></i> Sectional Analysis</h2>

                    <div class="c-list owl-carousel owl-theme" id="secAnalysis">
                        @foreach($anas as $ans)
                            <div class="item res-sec-analysis-box">
                                <h5 class="text-center">{{ $ans['secName'] }}</h5>
                                <table class="table table-striped">
                                    <tbody>
                                        
                                        
                                        <tr>
                                        <th scope="row">Subject Marks</th>
                                        <td>{{ $ans['secdata']->total_marks }}</td>
                                        </tr>
                                        <tr>
                                        <th scope="row">Correct Marks</th>
                                        <td>{{ $ans['secdata']->right_marks }}</td>
                                        </tr>
                                        <tr>
                                        <th scope="row">Wrong Marks</th>
                                        <td>{{ $ans['secdata']->wrong_marks }}</td>
                                        </tr>
                                        <tr>
                                        <th scope="row">Obtained Marks</th>
                                        <td>{{ $ans['secdata']->your_marks }}</td>
                                        </tr>
                                        <tr>
                                        <th scope="row">Percentage(%)</th>
                                        <td>{{ $ans['perc'] }}</td>
                                        </tr>
                                        <tr>
                                        <th scope="row">Average Marks</th>
                                        <td>{{ number_format((float)$ans['avg'], 2, '.', '') }}</td>
                                        </tr>
                                        <tr>
                                        <th scope="row">Toppers Marks</th>
                                        <td>{{ $ans['topr']->your_marks }}</td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
            
                    </div>

                </div>

                <div class="score-box">
                    <h2><i class="fal fa-chart-pie scicon"></i> Graphical Analysis</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="chart-wr mt-30">
                                <div id="questionChart"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="chart-wr mt-30">
                                <div id="minMax"></div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="score-box">
                    <h2><i class="fal fa-chart-pie scicon"></i> Comparative Analysis</h2>
                    
                        <div class="chart-wr mt-30 ">
                            <div id="comparativeChart"></div>
                        </div>
                    
                </div>

                <div class="text-center mt-50">
                    <a class="btn btn-primary" href="{{ url('student/testAnswers/'.$res->resultId) }}"><i class="fas fa-poll-h"></i> Test Answer</a>
                </div>


            </div>
        </div>     
    </div>     
</div>


@endsection

@section('javascript')

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        var rm = parseInt("<?php echo($correct_ans); ?>");
        var wm = parseInt("<?php echo($wrong_ans); ?>");
        var sk = parseInt("<?php echo($skipped); ?>");
        var options = {
          series: [rm,wm,sk],
          chart: {
          width: 380,
          type: 'pie',
          
        },
        labels: ['Right Answers', 'Wrong Answers', 'Skipped Questions'],
        
        colors: ['#2ecc71', '#e74c3c', '#f1c40f'],
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 300
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };

        var chart = new ApexCharts(document.querySelector("#questionChart"), options);
        chart.render();
    </script>
    <script>
        
        var options = {
        series: [{
            name: '',
            data: [
                {
                x: "Min",
                y: parseInt("<?php echo($overs['minmarks']->final_marks);?>")
                },
                {
                x: "Your",
                y: parseInt("<?php echo($res->final_marks);?>")
                },
                {
                x: "Topper",
                y: parseInt("<?php echo($topper->final_marks);?>")
                }
            ]
        }],
        chart: {
          type: 'area',
          height: 350,
          zoom: {
              enabled:false
          }
        },
        dataLabels: {
          enabled: true
        },
        stroke: {
          curve: 'smooth'
        },
        
        title: {
          text: 'Min Max ',
          align: 'left',
          style: {
            fontSize: '14px'
          }
        },
        xaxis: {
          axisBorder: {
            show: true
          },
          axisTicks: {
            show: true
          }
        },
        yaxis: {
          opposite: true,
          axisBorder: {
            show: true,
          },
          axisTicks: {
            show: true
          }
        },
        fill: {
          opacity: 0.5
        },
        
        };

        var chart = new ApexCharts(document.querySelector("#minMax"), options);
        chart.render();
    </script>

    <script>
        
        var options = {
          series: [parseFloat('<?php echo $overs["percentage"]; ?>'), parseFloat('<?php echo $overs["accuracy"]; ?>'), parseFloat('<?php echo $overs["percentile"]; ?>')],
          chart: {
          height: 400,
          type: 'radialBar',
        },
        plotOptions: {
          radialBar: {
            dataLabels: {
              name: {
                fontSize: '22px',
              },
              value: {
                fontSize: '30px',
              },
              total: {
                show: true,
                color: '#e74c3c',
                label: 'Total',
                formatter: function (w) {
                  // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                  return 100
                }
              }
            }
          }
        },
        labels: ['Percentage', 'Accuracy', 'Percentile'],
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 300,
              height: 300,
            }
          }}],
        };

        var chart = new ApexCharts(document.querySelector("#radialChart"), options);
        chart.render();
    </script>

    <script>
           var options = {
          series: [
                {
                    name: "Score",
                    data: [parseInt('<?php echo $res->final_marks; ?>'), parseInt('<?php echo $topper->final_marks; ?>'), parseInt('<?php echo $average["score"]; ?>')]
                }, {
                    name: "Correct",
                    data: [parseInt('<?php echo $res->correct_ans; ?>'), parseInt('<?php echo $topper->correct_ans; ?>'), parseInt('<?php echo $average["right"]; ?>')]
                }, {
                    name: "Incorrect",
                    data: [parseInt('<?php echo $res->wrong_ans; ?>').toFixed(2), parseInt('<?php echo $topper->wrong_ans; ?>').toFixed(2), parseInt('<?php echo $average["wrong"]; ?>').toFixed(2)]
                },
                {
                    name: "Accuracy",
                    data: [parseInt('<?php echo $overs["accuracy"]; ?>').toFixed(2), parseInt('<?php echo $overs["topperAccuracy"]; ?>').toFixed(2), parseInt('<?php echo $average["accuracy"]; ?>').toFixed(2)]
                }, {
                    name: "Attempt",
                    data: [parseInt('<?php echo $res->attempts; ?>').toFixed(2), parseInt('<?php echo $topper->attempts; ?>').toFixed(2), parseInt('<?php echo $average["attempts"]; ?>').toFixed(2)]
                }, {
                    name: "Time",
                    data: [
                        parseInt(parseInt('<?php echo $res->time_taken; ?>') / 60).toFixed(2), 
                        parseInt(parseInt('<?php echo $topper->time_taken; ?>') / 60).toFixed(2), 
                        parseInt(parseInt('<?php echo $average["time_taken"]; ?>')/ 60).toFixed(2)]
                }
            ],
          chart: {
          type: 'bar',
          height: 500
        },
        plotOptions: {
          bar: {
            horizontal: false,
            vertical: true,
            dataLabels: {
              position: 'top',
            },
          }
        },
        dataLabels: {
          enabled: false,
          offsetX: 1,
          style: {
            fontSize: '10px',
            colors: ['#fff']
          }
        },
        stroke: {
          show: true,
          width: 1,
          colors: ['#fff']
        },
        tooltip: {
          shared: true,
          intersect: false
        },
        xaxis: {
          categories: ['You', 'Topper', 'Avarage'],
        },
        yaxix: {
            floating: true,
            decimalsInFloat: 4,
            axisBorder: {
                show: true,
            },
            axisTicks: {
                show: true
            }
        },
        colors: ['#008ffbd9', '#00e396d9', 'rgb(255, 69, 96)', 'rgb(254, 176, 25)', 'rgb(119, 93, 208)']
        
        };

        var chart = new ApexCharts(document.querySelector("#comparativeChart"), options);
        chart.render();
    </script>

    <script>
        $('#secAnalysis').owlCarousel({
        loop:false,
        margin:10,
        nav: true,

        autoplay:true,
        autoplayTimeout:10000,
        autoplayHoverPause:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:2
            }
        }
    });
    </script>

@endsection