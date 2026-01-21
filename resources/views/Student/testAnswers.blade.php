@extends('layout')
@section('title')
Test Detailed Answers
@endsection
@section('content')
<div class="main-box2" style="padding-top: 0px;">
    <div class="udbox fixed-top">
        <div class="row">
            <div class="col-7 col-md-6">
<!--                <h3 class="text-white">SUCCESSCURVE<sup>.IN</sup></h3>-->
                <p class="text-white cdp">Test: {{ $tsts->tName }}</p>
            </div>
            <div class="col-5 col-md-6 smt20">
                <div class="row">
                    <div class="col-12 col-md-12 text-right">
                         <a href="{{ url('student/dashboard') }}" class="submitBtn dsmn float-right" >Go Back</a>
                        <div id="hstbtn" class="right-300 dsmf"><i class="fas fa-bars"></i></div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <!--    COntainer Starts Here    -->
    <div class="container-fluid testbbox">
        
        <div class="main-q">
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
                        {{-- @if ($que->qwType == "radio" || $que->qwType == "checkbox") --}}
                            <?php
                                $i = 1;
                                $options = json_decode(json_encode(json_decode($que->qwOptions)), true);
                            
                                $ops = $que->totalOptions;
                                for($i = 1; $i <= $ops; $i++){
                                    // print_r($qids);
                                    // die();
                                    if(in_array($que->qwId, $qids) && $examAnswers[$que->qwId]['remarks'] == 0){
                                        // dd("hello"); 
                                        // die();
                                        ?>
                                        
                                        @if ($que->qwType == "radio")
                                            <label class="radio
                                                @if ($que->qwCorrectAnswer == $i)
                                                    brgr
                                                @elseif ($examAnswers[$que->qwId]['answer'] == $i) 
                                                    brrr  
                                                @endif
                                                ">
                                                <input type="radio" name="answer[<?php echo $count;?>][]" value="<?php echo $i;?>" id="answer_value<?php echo $count.'-'.$i;?>">
                                                <span class="option" style="font-size: 15px !important;"><span class="ono"><?php echo $i;?></span> {!! $options['option'.$i] !!}</span>
                                            </label>
                                        @elseif ($que->qwType == "checkbox")
                                            <?php 
                                                $answer = explode(",", $examAnswers[$que->qwId]['answer']);
                                                $corrAnswer = explode(",", $que->qwCorrectAnswer); 
                                            
                                            ?>
                                            <label 
                                            class="
                                                radio
                                                @if (in_array($i, $corrAnswer))
                                                    brgr
                                                @elseif (in_array($i, $answer))
                                                    brrr  
                                                @endif
                                            ">
                                                <input type="checkbox" name="answer[<?php echo $count;?>][]" value="<?php echo $i;?>" id="answer_value<?php echo $count.'-'.$i;?>">
                                                <span class="option" style="font-size: 15px !important;"><span class="ono"><?php echo $i;?></span> {!! $options['option'.$i] !!}</span>
                                            </label>
                                            
                                        @elseif ($que->qwType == 'nat')

                                            
                                            <div class="form-group" style="padding-left: 40px; padding-right: 40px">

                                                <input type="number" name="answer<?php echo $count;?>" id="answer<?php echo $count;?>" class="form-control" placeholder="Enter Answer" value="{{ $examAnswers[$que->qwId]['answer'] }}" readonly style="border-color:red;" >
                                            </div>
                                        @endif
                                        <?php
                                    } else if (in_array($que->qwId, $qids) && $examAnswers[$que->qwId]['remarks'] == 1){
                                        ?>
                                        @if ($que->qwType == "radio")
                                            <label class="radio
                                                @if ($que->qwCorrectAnswer == $i)
                                                    brgr  
                                                @endif
                                                ">
                                                <input type="radio" name="answer[<?php echo $count;?>][]" value="<?php echo $i;?>" id="answer_value<?php echo $count.'-'.$i;?>">
                                                <span class="option" style="font-size: 15px !important;"><span class="ono"><?php echo $i;?></span> {!! $options['option'.$i] !!}</span>
                                            </label>
                                        @elseif ($que->qwType == "checkbox")
                                            <?php
                                                $corrAnswer = explode(",", $que->qwCorrectAnswer); 
                                            
                                            ?>
                                            <label 
                                            class="
                                                radio
                                                @if (in_array($i, $corrAnswer))
                                                    brgr
                                                @endif
                                            ">
                                                <input type="checkbox" name="answer[<?php echo $count;?>][]" value="<?php echo $i;?>" id="answer_value<?php echo $count.'-'.$i;?>">
                                                <span class="option" style="font-size: 15px !important;"><span class="ono"><?php echo $i;?></span> {!! $options['option'.$i] !!}</span>
                                            </label>
                                            
                                        @elseif ($que->qwType == 'nat')

                                            
                                            <div class="form-group" style="padding-left: 40px; padding-right: 40px">

                                                <input type="number" name="answer<?php echo $count;?>" id="answer<?php echo $count;?>" class="form-control" placeholder="Enter Answer" value="{{ $que->qwCorrectAnswer }}" readonly style="border-color:green;" >
                                            </div>
                                        @endif
                                        <?php
                                    } else {
                                        ?>
                                        @if ($que->qwType == "radio")
                                            <label class="radio
                                                @if ($que->qwCorrectAnswer == $i)
                                                    brwr  
                                                @endif
                                                ">
                                                <input type="radio" name="answer[<?php echo $count;?>][]" value="<?php echo $i;?>" id="answer_value<?php echo $count.'-'.$i;?>">
                                                <span class="option" style="font-size: 15px !important;"><span class="ono"><?php echo $i;?></span> {!! $options['option'.$i] !!}</span>
                                            </label>
                                        @elseif ($que->qwType == "checkbox")
                                            <?php
                                                $corrAnswer = explode(",", $que->qwCorrectAnswer); 
                                            
                                            ?>
                                            <label 
                                            class="
                                                radio
                                                @if (in_array($i, $corrAnswer))
                                                    brwr
                                                @endif
                                            ">
                                                <input type="checkbox" name="answer[<?php echo $count;?>][]" value="<?php echo $i;?>" id="answer_value<?php echo $count.'-'.$i;?>">
                                                <span class="option" style="font-size: 15px !important;"><span class="ono"><?php echo $i;?></span> {!! $options['option'.$i] !!}</span>
                                            </label>
                                            
                                        @elseif ($que->qwType == 'nat')

                                            
                                            <div class="form-group" style="padding-left: 40px; padding-right: 40px">

                                                <input type="number" name="answer<?php echo $count;?>" id="answer<?php echo $count;?>" class="form-control" placeholder="Enter Answer" value="{{ $que->qwCorrectAnswer }}" readonly style="border-color:red;" >
                                            </div>
                                        @endif
                                        <?php
                                    }
                                }

                                if ($que->qwType == "nat"){
                                    if(in_array($que->qwId, $qids) && $examAnswers[$que->qwId]['remarks'] == 0){
                                        ?>
                                            
                                            <div class="form-group" style="padding-left: 40px; padding-right: 40px">

                                                <input type="number" name="answer<?php echo $count;?>" id="answer<?php echo $count;?>" class="form-control" placeholder="Enter Answer" value="{{ $examAnswers[$que->qwId]['answer'] }}" readonly style="border-color:red;" >
                                            </div>
                                        <?php
                                    } else if (in_array($que->qwId, $qids) && $examAnswers[$que->qwId]['remarks'] == 1){
                                        ?>
                                         
                                            <div class="form-group" style="padding-left: 40px; padding-right: 40px">

                                                <input type="number" name="answer<?php echo $count;?>" id="answer<?php echo $count;?>" class="form-control" placeholder="Enter Answer" value="{{ $examAnswers[$que->qwId]['answer'] }}" readonly style="border-color:green;" >
                                            </div>
                                        <?php
                                    } else {
                                        ?>
                                            <div class="form-group" style="padding-left: 40px; padding-right: 40px">

                                                <input type="number" name="answer<?php echo $count;?>" id="answer<?php echo $count;?>" class="form-control" placeholder="Enter Answer" value="{{ $que->qwCorrectAnswer }}" readonly style="border-color:purple;" >
                                            </div>
                                        <?php
                                    }
                                }
                            ?>
                        {{-- @endif --}}
                        @if(!empty($que->qwHint))
                            
                        <div class="hintbox">
                            <p class="text-white"><b>Question Solution:</b> </p>
                            {!! $que->qwHint !!}  
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

                        {{-- @if ($que->qwType == "radio" || $que->qwType == "checkbox") --}}
                            <?php
                                $i = 1;
                                $options = json_decode(json_encode(json_decode($que->qwOptions)), true);
                            
                                $ops = $que->totalOptions;
                                for($i = 1; $i <= $ops; $i++){
                                    // print_r($qids);
                                    // die();
                                    if(in_array($que->qwId, $qids) && $examAnswers[$que->qwId]['remarks'] == 0){
                                        // dd("hello"); 
                                        // die();
                                        ?>
                                        
                                        @if ($que->qwType == "radio")
                                            <label class="radio
                                                @if ($que->qwCorrectAnswer == $i)
                                                    brgr
                                                @elseif ($examAnswers[$que->qwId]['answer'] == $i) 
                                                    brrr  
                                                @endif
                                                ">
                                                <input type="radio" name="answer[<?php echo $count;?>][]" value="<?php echo $i;?>" id="answer_value<?php echo $count.'-'.$i;?>">
                                                <span class="option" style="font-size: 15px !important;"><span class="ono"><?php echo $i;?></span> {!! $options['option'.$i] !!}</span>
                                            </label>
                                        @elseif ($que->qwType == "checkbox")
                                            <?php 
                                                $answer = explode(",", $examAnswers[$que->qwId]['answer']);
                                                $corrAnswer = explode(",", $que->qwCorrectAnswer); 
                                            
                                            ?>
                                            <label 
                                            class="
                                                radio
                                                @if (in_array($i, $corrAnswer))
                                                    brgr
                                                @elseif (in_array($i, $answer))
                                                    brrr  
                                                @endif
                                            ">
                                                <input type="checkbox" name="answer[<?php echo $count;?>][]" value="<?php echo $i;?>" id="answer_value<?php echo $count.'-'.$i;?>">
                                                <span class="option" style="font-size: 15px !important;"><span class="ono"><?php echo $i;?></span> {!! $options['option'.$i] !!}</span>
                                            </label>
                                            
                                        @elseif ($que->qwType == 'nat')
                                            ths sbabjh
                                            <div class="form-group" style="padding-left: 40px; padding-right: 40px">

                                                <input type="number" name="answer<?php echo $count;?>" id="answer<?php echo $count;?>" class="form-control" placeholder="Enter Answer" value="{{ $examAnswers[$que->qwId]['answer'] }}" readonly style="border-color:red;">
                                            </div>
                                        @endif
                                        <?php
                                    } else if (in_array($que->qwId, $qids) && $examAnswers[$que->qwId]['remarks'] == 1){
                                        ?>
                                        @if ($que->qwType == "radio")
                                            <label class="radio
                                                @if ($que->qwCorrectAnswer == $i)
                                                    brgr  
                                                @endif
                                                ">
                                                <input type="radio" name="answer[<?php echo $count;?>][]" value="<?php echo $i;?>" id="answer_value<?php echo $count.'-'.$i;?>">
                                                <span class="option" style="font-size: 15px !important;"><span class="ono"><?php echo $i;?></span> {!! $options['option'.$i] !!}</span>
                                            </label>
                                        @elseif ($que->qwType == "checkbox")
                                            <?php
                                                $corrAnswer = explode(",", $que->qwCorrectAnswer); 
                                            
                                            ?>
                                            <label 
                                            class="
                                                radio
                                                @if (in_array($i, $corrAnswer))
                                                    brgr
                                                @endif
                                            ">
                                                <input type="checkbox" name="answer[<?php echo $count;?>][]" value="<?php echo $i;?>" id="answer_value<?php echo $count.'-'.$i;?>">
                                                <span class="option" style="font-size: 15px !important;"><span class="ono"><?php echo $i;?></span> {!! $options['option'.$i] !!}</span>
                                            </label>
                                            
                                        @elseif ($que->qwType == 'nat')

                                            vsdk n n kkk
                                            <div class="form-group" style="padding-left: 40px; padding-right: 40px">

                                                <input type="number" name="answer<?php echo $count;?>" id="answer<?php echo $count;?>" class="form-control" placeholder="Enter Answer" value="{{ $que->qwCorrectAnswer }}" readonly style="border-color:green;" >
                                            </div>
                                        @endif
                                        <?php
                                    } else {
                                        ?>
                                        @if ($que->qwType == "radio")
                                            <label class="radio
                                                @if ($que->qwCorrectAnswer == $i)
                                                    brwr  
                                                @endif
                                                ">
                                                <input type="radio" name="answer[<?php echo $count;?>][]" value="<?php echo $i;?>" id="answer_value<?php echo $count.'-'.$i;?>">
                                                <span class="option" style="font-size: 15px !important;"><span class="ono"><?php echo $i;?></span> {!! $options['option'.$i] !!}</span>
                                            </label>
                                        @elseif ($que->qwType == "checkbox")
                                            <?php
                                                $corrAnswer = explode(",", $que->qwCorrectAnswer); 
                                            
                                            ?>
                                            <label 
                                            class="
                                                radio
                                                @if (in_array($i, $corrAnswer))
                                                    brwr
                                                @endif
                                            ">
                                                <input type="checkbox" name="answer[<?php echo $count;?>][]" value="<?php echo $i;?>" id="answer_value<?php echo $count.'-'.$i;?>">
                                                <span class="option" style="font-size: 15px !important;"><span class="ono"><?php echo $i;?></span> {!! $options['option'.$i] !!}</span>
                                            </label>
                                            
                                        @elseif ($que->qwType == 'nat')
                                        dfkd slkk ll
                                            <div class="form-group" style="padding-left: 40px; padding-right: 40px">

                                                <input type="number" name="answer<?php echo $count;?>" id="answer<?php echo $count;?>" class="form-control" placeholder="Enter Answer" value="{{ $que->qwCorrectAnswer }}" readonly style="border-color:red;" >
                                            </div>
                                        @endif
                                        <?php
                                    }
                                }
                                if ($que->qwType == "nat"){

                                    if(in_array($que->qwId, $qids) && $examAnswers[$que->qwId]['remarks'] == 0){
                                        ?>
                                            
                                            <div class="form-group" style="padding-left: 40px; padding-right: 40px">

                                                <input type="number" name="answer<?php echo $count;?>" id="answer<?php echo $count;?>" class="form-control" placeholder="Enter Answer" value="{{ $examAnswers[$que->qwId]['answer'] }}" readonly style="border-color:red;" >
                                            </div>
                                        <?php
                                    } else if (in_array($que->qwId, $qids) && $examAnswers[$que->qwId]['remarks'] == 1){
                                        ?>
                                         
                                            <div class="form-group" style="padding-left: 40px; padding-right: 40px">

                                                <input type="number" name="answer<?php echo $count;?>" id="answer<?php echo $count;?>" class="form-control" placeholder="Enter Answer" value="{{ $que->qwCorrectAnswer }}" readonly style="border-color:green;" >
                                            </div>
                                        <?php
                                    } else {
                                        ?>
                                            <div class="form-group" style="padding-left: 40px; padding-right: 40px">

                                                <input type="number" name="answer<?php echo $count;?>" id="answer<?php echo $count;?>" class="form-control" placeholder="Enter Answer" value="{{ $que->qwCorrectAnswer }}" readonly style="border-color:purple;" >
                                            </div>
                                        <?php
                                    }
                                }
                            ?>
                        {{-- @endif --}}
                        @if(!empty($que->qwHint))
                            
                        <div class="hintbox">
                            <p class="text-white"><b>Question Solution:</b> </p>
                            {!! $que->qwHint !!}  
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
                    <h6>Result Overview</h6>
                    <div class="notin">
                        
                        <div class="notinl">
                            <div class="qns2 answered" id=""></div>&nbsp; Right
                        </div>
                        <div class="notinl">
                            <div class="qns2 not-answered" id=""></div>&nbsp; Wrong
                        </div>
                        <div class="notinl">
                            <div class="qns2 review" id=""></div>&nbsp; Not Answered
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="controlbox fixed-bottom">
            <button class="ctrlBtn" id="prevBtn" onclick="javascript:prev_question();"><span class="dsmn">Prev</span><span class="dsm"><i class="fas fa-angle-left"></i></span></button>
            
            <button class="ctrlBtn" id="nextBtn" onclick="javascript:next_question()"><span class="dsmn">Next</span><span class="dsm"><i class="fas fa-angle-right"></i></span></button>

            <a href="{{ url('student/dashboard') }}" class="btn btn-sm btn-danger">Go Back</a>
            
        </div>
<!-- Container Ends Here -->
    </div> 
</div>


@endsection

@section('javascript')

<script>
    
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
 show_question(0);
</script>
@endsection
