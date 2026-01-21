 
@extends('layout')
@section('title')
Lecture
@endsection
@section('content')
<div class="main-box">
    <div class="container-fluide mt-100">
        <div class="row">
            <div class="col-md-4 l-box">
                <h3 class="course-content-title">Course Content</h3>
                <?php $count = 1;?>
                
                @foreach($weeks as $week)
                @if($contents->weekId == $week->weekId)
                <div class="accordion mt-30" id="accordionExample">
                  <div class="card m-card">
                    <div class="card-header m-header" id="headingOne<?php echo $count;?>">
                      <h2 class="mb-0">
                        <button class="btn btn-link text-white" type="button" data-toggle="collapse" data-target="#collapseOne<?php echo $count;?>" aria-expanded="true" aria-controls="collapseOne<?php echo $count;?>">
                          {{$week->weekName}}
                        </button>
                      </h2>
                    </div>
                    <div id="collapseOne<?php echo $count;?>" class="collapse show" aria-labelledby="headingOne<?php echo $count;?>" data-parent="#accordionExample">
                      <div class="card-body l-body">
                        <ul>
                            @foreach($lectures as $lecture)
                                @if($lecture->weekId == $week->weekId)
                                @if($contents->lectureId == $lecture->lectureId)
                                
                                <li class="l-li active"><a href="{{url('getLecture')}}/?courseId={{$lecture->courseId}}&lectureId={{$lecture->lectureId}}" class="l-a">{{ $lecture->lectureTitle}}</a></li>
                                @else
                                <li class="l-li"><a href="{{url('getLecture')}}/?courseId={{$lecture->courseId}}&lectureId={{$lecture->lectureId}}" class="l-a">{{ $lecture->lectureTitle}}</a></li>
                                @endif
                            @endif
                            @endforeach
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                @else
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
                                <li class="l-li"><a href="{{url('getLecture')}}/?courseId={{$lecture->courseId}}&lectureId={{$lecture->lectureId}}" class="l-a">{{ $lecture->lectureTitle}}</a></li>
                                @endif
                            @endforeach
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                @endif
                <?php $count++; ?>
                @endforeach
            </div>
            <div class="col-md-8 l-box">
                <div class="container">
<!--
                    @if($errors)
                        <div class="course-description mt-20">
                        {{ $errors }}
                        </div>
                    @endif
-->
                    {{-- {!! $contents !!} --}}
                    @if($contents->lectureType == "0")
                        
                            <h3 class="dash-header-title">{{$contents->lectureTitle}}</h3>
                            @if($contents->lectureVideo)
                            <div class="youtube-embed-wrapper" style="position:relative;padding-bottom:56.25%;padding-top:30px;height:0;overflow:hidden"><div class="js-player" data-plyr-provider="youtube" data-plyr-embed-id="{{ $contents->lectureVideo }}" style="position:absolute;top:0;left:0;width:100%;height:100%" width="640"></div></div>
                            @endif
                            <div class="course-description mt-20">
                            {!! $contents->lectureContent !!}
                            </div>
                    
                    @elseif ($contents->lectureType == "1")
                        <div class="testbbox two">

                        <div class="main-q two">
                            <div class="quesbox two">
                                <input type="hidden" name="csrf_token" id="csrf_token" value="{{ csrf_token() }}">
                
                                <div class="mainques" >
                                    <?php $count = 0;?>
                                    @foreach($ques as $que)
                                    <div class="qbx" id="q<?php echo $count;?>" style="margin-bottom: 20px;">
                                        <div class="qb">
                                            @if ($que['paragraphId'] != 0)
                                            <div class="qpaara" style="font-size: 15px;">
                                                <span class="text-danger">Paragraph:</span> {!! $que['paragraph'] !!}
                                            </div>
                                            <div class="qpaara mt-20">
                                                <span class="text-danger">Question No : {{ $count+1 }}</span> {!! $que['qwTitle'] !!}
                                            </div>
                                            @else
                                            <div class="qpaara">
                                                <span class="text-danger">Question No : {{ $count+1 }}</span>
                                                {!! $que['qwTitle'] !!}
                                            </div>
                                            @endif
                                            {{-- <h6 class="text-info">Question No : {{ $count+1 }}</h6>
                                            {!! $que->question !!} --}}


                                            <input type="hidden" id="qtype<?php echo $count;?>" value="{{ $que['qwType'] }}">
                
                                            <input type="hidden" id="qid<?php echo $count;?>" value="{{ $que['qwId'] }}">
                                            
                                            <input type="hidden" id="qans<?php echo $count;?>" value="{{ $que['qwCorrectAnswer'] }}">
                                            
                                        </div>
                        @if ($que['qwType'] == "radio" || $que['qwType'] == "checkbox")
                            <?php
                                $i = 1;
                                $options = json_decode(json_encode(json_decode($que['qwOptions'])), true);
                            
                                $ops = $que['totalOptions'];
                                for($i = 1; $i <= $ops; $i++){
                                    
                                    ?>
                                @if ($que['qwType'] == "radio")
                                    <label class="radio" onclick="checkAns('{{ $i }}','{{ $count }}', '{{ $que['qwCorrectAnswer'] }}')">
                                        <input type="radio" name="answer[<?php echo $count;?>][]" value="<?php echo $i;?>" id="answer_value<?php echo $count.'-'.$i;?>">
                                        <span class="option"><span class="ono"><?php echo $i;?></span> {!! $options['option'.$i] !!}</span>
                                    </label>
                                @elseif ($que['qwType'] == "checkbox")
                                    <label class="radio" onclick="checkAns('{{ $i }}', '{{ $count }}' , '{{ $que['qwCorrectAnswer'] }}')">
                                        <input type="checkbox" name="answer[<?php echo $count;?>][]" value="<?php echo $i;?>" id="answer_value<?php echo $count.'-'.$i;?>">
                                        <span class="option"><span class="ono"><?php echo $i;?></span> {!! $options['option'.$i] !!}</span>
                                    </label>
                                @endif
                            <?php
                                }
                            ?>
                        @elseif ($que['qwType'] == 'nat')
                            <div class="form-group" style="padding-left: 40px; padding-right: 40px">
                                {{-- <label for="answer<?php echo $count;?>" class="log-label">Answer</label> --}}

                                <input type="number" name="answer<?php echo $count;?>" id="answer<?php echo $count;?>" class="form-control" placeholder="Enter Answer" onblur="checkAns2('{{ $count }}', '{{ $que['qwCorrectAnswer'] }}')" >
                            </div>
                        @endif

                                        <div class="qb hint d-none" id="qbh<?php echo $count;?>">
                                            <h6 class="text-danger">Hint : </h6>
                                            {!! $que['qwHint']; !!}                            
                                        </div>
                                    </div>
                                    <hr color="blue">
                                    <?php $count++;?>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- Container Ends Here -->
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
    </div>    
</div>


<script src="https://cdn.plyr.io/3.5.6/plyr.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const player = Plyr.setup('.js-player');
       
    });
</script>
@endsection

@section('javascript')

<script src="{{ asset('js/set.js') }}"></script>

@endsection