
@extends('layout')

@section('title')
Preview Question
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
        
<!--        Dash-Container Starts   -->
        <div class="col-md-9 col-12 dash-container">
            
            
<!--            Error Box       -->
            @if(Session::get('errors'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>{{ $errors }}!</strong> 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @endif
            <div class="dash-header">
                <span class="dash-header-title">Preview Question</span>

            </div>
            @if(Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>{{ Session::get('success') }}!</strong> 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
            @endif
            <div class="dash-form-box">

                @if ($paragraphs != null)
                    <h6 class="text-primary">Paragraph: </h6>
                    {!! $paragraphs->prgContent !!}
                @endif
                <h6 class="text-danger m-3">Question: </h6> {!! $qns->qwTitle !!}


                <?php
                    $options = json_decode(json_encode(json_decode($qns->qwOptions)), true);

                    // print_r($options);
                    // die();
                ?>
                <div class="row">
                    @for ($i = 1; $i <= $qns->totalOptions; $i++)
                        <div class="col-md-6 mt-2 p-2" style="border: 1px solid black; border-radius: 10px;">
                            <h6 class="text-primary">Option {{ $i }}</h6>
                            {!! $options['option'.$i] !!}
                        </div>
                    @endfor
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6 class="text-success">Correct Answer: {{ ($qns->qwType != "nat") ? "Option ":''}} {{ $qns->qwCorrectAnswer }}</h6>

                    </div>
                </div>

                @if(!empty($qns->qwHint))
                            
                <div class="hintbox">
                    <p class="text-white"><b>Question Solution:</b> </p>
                    {!! $qns->qwHint !!}  
                </div>
                  
                @endif


            </div>        
      <!--        Container End   -->  
        </div>
        
        
        
        
    </div>
    
</div>

@endsection
