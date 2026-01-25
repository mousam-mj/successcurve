@extends('Exam.testLayout')
@section('title')
Take Test
@endsection
@section('content')
<div class="main-box2" style="padding-top: 0px;">
    <div class="ring-out hidden">
        <div class="ring" id="ring">Submitting
          <span></span>
        </div>
    </div>
    <div class="udbox fixed-top">
        <div class="row">
            <div class="col-7 col-md-6">
<!--                <h3 class="text-white">SUCCESSCURVE<sup>.IN</sup></h3>-->
                <p class="text-white cdp">Test: {{ $tsts->tName }}</p>
            </div>
            <div class="col-5 col-md-6 smt20">
                <div class="row">
                    <div class="col-8 col-md-6 text-right">
                        <p class="cdp"><i class="fas fa-stopwatch text-white"></i> &nbsp;<span id="timer"> </span></p>
                        
                    </div>
                    <div class="col-4 col-md-6 text-right">
                         <button class="submitBtn dsmn float-right" onclick="submit_test();">Submit Test</button>
                        <div id="hstbtn" class="right-300 dsmf"><i class="fas fa-bars"></i></div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <!--    COntainer Starts Here    -->
    <div class="container-fluid testbbox">
        
        <div class="main-q">
            <div class="final-dialoge" id="final-dialouge">
                <div class="final-dbox">
                    <button class="closebtn" onclick="closeDialouge();"><i class="fas fa-times"></i></button>
                    <h6>Are You Sure Want to Submit The Test?</h6>
                    <div class="notin">
                        <div class="notinl">
                            <div class="qns2 not-visited" id="notv2"></div>&nbsp; Not Visited
                        </div>
                        <div class="notinl">
                            <div class="qns2 answered" id="answ2"></div>&nbsp; Answered
                        </div>
                        <div class="notinl">
                            <div class="qns2 not-answered" id="nota2"></div>&nbsp; Not Answered
                        </div>
                        <div class="notinl">
                            <div class="qns2 review" id="mr2"></div>&nbsp; Mark for Review
                        </div>
                        <div class="notinr">
                            <div class="qns2 answered-review" id="smr2"></div>&nbsp; Save and Mark for Review
                        </div>
                        <div class="notinr text-center">
                            <button class="submitBtn" onclick="final_submit_test();">Submit</button>
                        </div>
                    </div>
                </div>   
            </div>
            <div class="final-dialoge" id="final-dialouge2">
                <div class="final-dbox">
                    <button class="closebtn" onclick="closeDialouge2();"><i class="fas fa-times"></i></button>
                    <textarea class="form-control" rows="6" id="reportText" placeholder="Write The Issue"></textarea>
                    
                    <div class="notinr text-center">
                        <button class="submitBtn" onclick="submitReport();">Report Question</button>
                    </div>
                    
                </div>   
            </div>
            <div class="quesbox">
                
                <form method="post" action="{{'exam/submitQuiz'}}">
                @csrf
                     
                    <input type="hidden" name="tqn" id="tqn" value="{{$tqns}}">
                    <input type="hidden" name="duration" id="duration" value="{{$tsts->duration}}">
                    <input type="hidden" name="testId" id="testId" value=" {{ $tsts->tId }}">
                    <input type="hidden" name="resultId" id="resultId" value=" {{ $ress }}">
                    <input type="hidden" name="csrf_token" id="csrf_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="baseurl" id="baseurl" value="{{ url('/') }}">
                    
                    
                    
                <div class="quesindi">
                    <div class="qnobox text-left">
                        <p class="cdp text-white">Q<span id="qno"> 01</span> : <span id="qtpe">Multiple Choice Question</span></p>
                    </div>
                    <div class="markbox text-right">
                        <p class="cdp text-white">Marks : <span id="pmarks">01</span>&nbsp;&nbsp;&nbsp; Negative Marks : <span id="pnegmarks">0.33</span></p>
                    </div>
                </div>
                <div class="mainques">
                    <?php $count = 0;?>
                    @foreach ($testSections as $testSection)
                    
                    @if ($testSection['questions'] != null)
                    @foreach($testSection['questions'] as $que)
                    <div class="qbx" id="q<?php echo $count;?>">
                        <div class="qb">
                            @if ($que->paragraphId != 0)
                            <div class="qpaara" style="font-size: 15px;">
                                <span class="text-danger">Paragraph:</ nspan> {!! $que->paragraph !!}
                            </div>
                            <div class="qpaara mt-20" style="font-size: 15px !important;">
                                <span class="text-danger">Question:</span> {!! $que->qwTitle !!}
                            </div>
                            @else
                            <div class="qpaara">
                                {!! $que->qwTitle !!}
                            </div>
                            @endif
                            
                            <input type="hidden" id="qtype<?php echo $count;?>" value="{{ $que->qwType }}">
                            <input type="hidden" id="qmarks<?php echo $count;?>" value="{{ $testSection['tsec']->tsMarks }}">
                            <input type="hidden" id="qnegmarks<?php echo $count;?>" value="{{ $testSection['tsec']->tsNegMarks }}">
                            <input type="hidden" id="qid<?php echo $count;?>" value="{{ $que->qwId }}">
                            <input type="hidden" id="tsec<?php echo $count;?>" value ="{{ $testSection['tsec']->tsecId }}">
                        </div>
                        @if ($que->qwType == "radio" || $que->qwType == "checkbox")
                            <?php
                                $i = 1;
                                $options = json_decode(json_encode(json_decode($que->qwOptions)), true);
                            
                                $ops = $que->totalOptions;
                                for($i = 1; $i <= $ops; $i++){
                                    
                                    ?>
                                @if ($que->qwType == "radio")
                                    <label class="radio" onclick="checkrad()">
                                        <input type="radio" name="answer[<?php echo $count;?>][]" value="<?php echo $i;?>" id="answer_value<?php echo $count.'-'.$i;?>">
                                        <span class="option" style="font-size: 15px !important;"><span class="ono"><?php echo $i;?></span> {!! $options['option'.$i] !!}</span>
                                    </label>
                                @elseif ($que->qwType == "checkbox")
                                    <label class="radio" onclick="checkrad()">
                                        <input type="checkbox" name="answer[<?php echo $count;?>][]" value="<?php echo $i;?>" id="answer_value<?php echo $count.'-'.$i;?>">
                                        <span class="option" style="font-size: 15px !important;"><span class="ono"><?php echo $i;?></span> {!! $options['option'.$i] !!}</span>
                                    </label>
                                @endif
                            <?php
                                }
                            ?>
                        @elseif ($que->qwType == 'nat')
                            <div class="form-group" style="padding-left: 40px; padding-right: 40px">
                                {{-- <label for="answer<?php echo $count;?>" class="log-label">Answer</label> --}}

                                <input type="number" name="answer<?php echo $count;?>" id="answer<?php echo $count;?>" class="form-control" placeholder="Enter Answer" onblur="checkrad()" >
                            </div>
                        @endif
                        
                        
                    </div>
                    <?php $count++;?>
                    @endforeach
                    @endif

                    @if ($testSection['paragraphs'] != null)
                    @foreach($testSection['paragraphs'] as $que)
                    <div class="qbx2" id="q<?php echo $count;?>">
                        <div class="parabox">
                            <div class="qb">
                                @if ($que->paragraphId != 0)
                                
                                    <div class="qpaara" style="font-size: 15px;">
                                        <span class="text-danger">Paragraph:</ nspan> {!! $que->prgContent !!}
                                    </div>
                                @endif

                                <input type="hidden" id="qtype<?php echo $count;?>" value="{{ $que->qwType }}">
                                <input type="hidden" id="qmarks<?php echo $count;?>" value="{{ $testSection['tsec']->tsMarks }}">
                                <input type="hidden" id="qnegmarks<?php echo $count;?>" value="{{ $testSection['tsec']->tsNegMarks }}">
                                <input type="hidden" id="qid<?php echo $count;?>" value="{{ $que->qwId }}">
                                <input type="hidden" id="tsec<?php echo $count;?>" value ="{{ $testSection['tsec']->tsecId }}">
                            </div>
                        </div>
                        <div class="paraquesbox">
                            <div class="qb">
                                <div class="qpaara mt-20" style="font-size: 15px !important;">
                                    <span class="text-danger">Question:</span> {!! $que->qwTitle !!}
                                </div>
                            </div>

                        @if ($que->qwType == "radio" || $que->qwType == "checkbox")
                            <?php
                                $i = 1;
                                $options = json_decode(json_encode(json_decode($que->qwOptions)), true);
                            
                                $ops = $que->totalOptions;
                                for($i = 1; $i <= $ops; $i++){
                                    
                                    ?>
                                @if ($que->qwType == "radio")
                                    <label class="radio" onclick="checkrad()">
                                        <input type="radio" name="answer[<?php echo $count;?>][]" value="<?php echo $i;?>" id="answer_value<?php echo $count.'-'.$i;?>">
                                        <span class="option" style="font-size: 15px !important;"><span class="ono"><?php echo $i;?></span> {!! $options['option'.$i] !!}</span>
                                    </label>
                                @elseif ($que->qwType == "checkbox")
                                    <label class="radio" onclick="checkrad()">
                                        <input type="checkbox" name="answer[<?php echo $count;?>][]" value="<?php echo $i;?>" id="answer_value<?php echo $count.'-'.$i;?>">
                                        <span class="option" style="font-size: 15px !important;"><span class="ono"><?php echo $i;?></span> {!! $options['option'.$i] !!}</span>
                                    </label>
                                @endif
                            <?php
                                }
                            ?>
                        @elseif ($que->qwType == 'nat')
                            <div class="form-group" style="padding-left: 40px; padding-right: 40px">
                                {{-- <label for="answer<?php echo $count;?>" class="log-label">Answer</label> --}}

                                <input type="number" name="answer<?php echo $count;?>" id="answer<?php echo $count;?>" class="form-control" placeholder="Enter Answer" onblur="checkrad()" >
                            </div>
                        @endif
                        </div>
                        
                    </div>
                    <?php $count++;?>
                    @endforeach
                    @endif


                        
                    @endforeach
                    
                </div>
                </form>
            </div>

            <div class="quespallete">
                
                <div class="quess">
                    <div class="tsecs">
                        @foreach($tsecs as $tsec)
                        <button class="tsecbtn" id="tsec1"> {{ $tsec->tsecName }} </button>
                        @endforeach
                    </div>
                    <div class="qps">
                        <?php
                            for($i = 0; $i < $tqns; $i++){
                                ?>
                            <div class="qns not-visited" onclick="show_question(<?php echo $i;?>);" id="qbtn<?php echo $i;?>"><?php echo $i+1; ?></div>
                        <?php
                            }
                        ?>
                        
                    </div>
                </div>
                <div class="noticebox">
                    <h6>Test Overview</h6>
                    <div class="notin">
                        <div class="notinl">
                            <div class="qns2 not-visited" id="notv"></div>&nbsp; Not Visited
                        </div>
                        <div class="notinl">
                            <div class="qns2 answered" id="answ"></div>&nbsp; Answered
                        </div>
                        <div class="notinl">
                            <div class="qns2 not-answered" id="nota"></div>&nbsp; Not Answered
                        </div>
                        <div class="notinl">
                            <div class="qns2 review" id="mr"></div>&nbsp; Mark for Review
                        </div>
                        <div class="notinr">
                            <div class="qns2 answered-review" id="smr"></div>&nbsp; Save and Mark for Review
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="controlbox fixed-bottom">
            <button class="ctrlBtn" id="prevBtn" onclick="javascript:prev_question();"><span class="dsmn">Prev</span><span class="dsm"><i class="fas fa-angle-left"></i></span></button>
            
            <button class="clearBtn" id="clearBtn" onclick="javascript:clear_response();"><span class="dsmn">Clear</span><span class="dsm"><i class="fas fa-eraser"></i></span></button>
            
            <button class="clearBtn" id="saveBtn" onclick="javascript:report_question();"><span class="dsmn">Report Question</span><span class="dsm"><i class="fas fa-exclamation-triangle"></i></span></button>
            
            <button class="ctrlBtn" id="nextBtn" onclick="javascript:next_question()"><span class="dsmn">Next</span><span class="dsm"><i class="fas fa-angle-right"></i></span></button>
            
            <button class="reviewBtn" id="reviewBtn" onclick="javascript:review_later();"><span class="dsmn">Mark for Review</span><span class="dsm"><i class="far fa-bookmark"></i></span></button>
            
            <button class="reviewBtn" id="ReviewAnsBtn" onclick="javascript:save_review();"><span class="dsmn">Save and Mark for Review</span><span class="dsm"><i class="far fa-check-square"></i></span></button>
            
            <button class="submitBtn dsm" onclick="submit_test();">Submit Test</button>
            
        </div>
<!-- Container Ends Here -->
    </div> 
</div>


@endsection

@section('javascript')

<script>
    var mytime= 0;
   
var myTimer;
function clock() {
    myTimer = setInterval(myClock, 1000);
    var c = <?php echo $tsts->duration;?> * 60; //Initially set to 1 hour 40 Minutes


    function myClock() {
        --c;
        mytime++;
        var seconds = c % 60; // Seconds that cannot be written in minutes
        var secondsInMinutes = (c - seconds) / 60; // Gives the seconds that COULD be given in minutes
        var minutes = secondsInMinutes % 60; // Minutes that cannot be written in hours
        var hours = (secondsInMinutes - minutes) / 60;
        // Now in hours, minutes and seconds, you have the time you need.
        document.getElementById("timer").innerHTML = hours.toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false}) + "h: " + minutes.toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false}) + "m: " + seconds.toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false}) +"s";
//        console.log(hours + ":" + minutes + ":" + seconds)
        if (c == 0) {
//            clearInterval(myTimer);
            final_submit_test();
        }
    }
}

clock();
    
document.onkeydown = function(){
  switch (event.keyCode){
        case 116 : //F5 button
            event.returnValue = false;
            event.keyCode = 0;
            return false;
        case 82 : //R button
            if (event.ctrlKey){ 
                event.returnValue = false;
                event.keyCode = 0;
                return false;
            }
    }
}


$('#hstbtn').click(function(){
    if($(this).hasClass('left-300')){
        $('.quespallete').css('right', '-300px');
        $(this).removeClass('left-300');
        $(this).addClass('right-300');
    }
    else if($(this).hasClass('right-300')){
        $('.quespallete').css('right', '0px');
        $(this).addClass('left-300');
        $(this).removeClass('right-300');
    }
});

</script>
<script src="{{asset('js/app01.js')}}"></script>
<script>
// Wait for MathJax to be ready before showing first question
if (window.MathJax && window.MathJax.startup) {
    MathJax.startup.promise.then(function() {
        show_question(0);
        // Initial render after MathJax is ready
        setTimeout(function() {
            if (MathJax.typesetPromise) {
                MathJax.typesetPromise().catch(function (err) {
                    console.log('MathJax initial render error:', err);
                });
            }
        }, 500);
    });
} else {
    // Fallback if MathJax loads after this script
    $(document).ready(function() {
        setTimeout(function() {
            show_question(0);
            if (window.MathJax && MathJax.typesetPromise) {
                MathJax.typesetPromise().catch(function (err) {
                    console.log('MathJax render error:', err);
                });
            }
        }, 1000);
    });
}
 
 // Re-render MathJAX when questions are shown
 function renderMathJax() {
     if (window.MathJax && MathJax.typesetPromise) {
         setTimeout(function() {
             MathJax.typesetPromise().catch(function (err) {
                 console.log('MathJax render error:', err);
             });
         }, 200);
     }
 }
</script>
@endsection
