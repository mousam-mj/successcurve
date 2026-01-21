 
@extends('layout')
@section('title')
Mock Test 
@endsection
@section('content')
<div class="main-box"> 
    <div class="ctsbox">
        <div class="ctxs">
            <div style="position:relative;" class="tgBtnWr">
                <button class="hiddenfilter" id="tgbtn"><i class="fas fa-caret-square-down"></i></button>
            </div>
            <h4 class="ctxh2">Find Your Test</h4>
            <form action="{{ url('mockTest') }}" method="get" class="filter-form">
                
                <div class="form-group">
                    <select class="form-control" id="cls" name="cls">
                        <option value="0">--Select Class--</option>
                    </select>
                </div>
                <div class="form-group ">
                    <select class="form-control" id="subject" name="subject">
                        <option value="0">--Select Subject--</option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn form-control btn-primary" type="submit">Apply Filter</button>
                </div>
                <div class="form-group">
                    <a class="btn form-control btn-dark" href="{{ URL('mock-test') }}">Clear Filter</a>
                </div>
            </form>
            @if($cids ?? '')
                <input type="hidden" id="clid" value="{{ $cids ?? '' }}">
            @endif
            @if($sids ?? '')
                <input type="hidden" id="sbid" value="{{ $sids ?? '' }}">
            @endif
            
        </div>


        <div class="ctxr">
            <div class="catogery-box">
        
        @foreach($classes as $class)
        
        <h4 class="heading-text">
            {{ $class['class']->className}} Tests 
        </h4>

        <div class="cn-listmain mt-5">
            @foreach($class['tests'] as $test)
                <div class="cn-list-item">
                    <a class="new-c-item" href="{{ url('exam/test/'.$test->tId.'/'.$test->tURI)}}">
                        <div class="cn-in-left">
                            @if ($test->tPrice > 0)
                                <span class="badge-main badge-paid">₹ {{ $test->tPrice }}</span>
                            @else
                                <span class="badge-main badge-free">Free</span>
                            @endif
                            
                            <img src="{{ URL::asset($test->tImage) }}" alt="">
                        </div>
                        <div class="cn-in-right">
                            <h5 class="cnh5" title="{{$test->tName}}">{{substr($test->tName,0,60)}}..</h5>
                            <div class="cnp">
                                <span class="cnp-sl">
                                    {{$test->subjectName}}
                                </span>
                                <span class="cnp-sr">
                                    @if($test->className == "Under Graduate")
                                        {{ 'UG' }}
                                    @elseif($test->className == "Post Graduate")
                                        {{ 'PG' }}
                                    @else
                                        {{$test->className}}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </a>
                
                </div>
               
            @endforeach
        </div>
        <div class="text-center m-4">
            <a href="{{ url('mocktest/'.$class['class']->classId) }}" class="btn btn-primary btn-sm">View All</a>
        </div>
        
        @endforeach
    </div>
        </div>
    </div>    
</div>

@endsection
@section('javascript')
<script>
    var clid = 0;
    var sbid =0;
    if(document.getElementById('clid')){
        clid = document.getElementById('clid').value;        
    }
    if(document.getElementById('sbid')){
        sbid = document.getElementById('sbid').value;        
    }
    
     $.ajax({
    url: "/getSubjects",
    type: "POST",
    data:{ 
        _token: '{{csrf_token()}}'
    },
    cache: false,
    dataType: 'json',
    success: function(dataResult){
//        console.log(dataResult);
        var resultData = dataResult.data;
        var bodyData = '';
        $.each(resultData,function(index,row){
                if(sbid == row.subjectId){
                    console.log(sbid);
                    bodyData+="<option value="+ row.subjectId +" selected >"+ row.subjectName +"</option>";
                }else{
                    bodyData+="<option value="+ row.subjectId +">"+ row.subjectName +"</option>";
                }    
            
            })
            $("#subject").append(bodyData);
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
//            console.log(dataResult);
            var resultData = dataResult.data;
            var bodyData = '';
            $.each(resultData,function(index,row){
                if(clid == row.classId){
                    console.log(clid);
                    bodyData+="<option value="+ row.classId +" selected >"+ row.className +"</option>";
                }else{
                    bodyData+="<option value="+ row.classId +">"+ row.className +"</option>";
                }
            })
            $("#cls").append(bodyData);
        }
    });
    
    
    $('#tgbtn').click(function(){
       if($(this).hasClass('hiddenfilter')){
           $('.ctxs').css('position', 'absolute');
           $('.ctxs').css('left', '0');
           $(this).removeClass('hiddenfilter');
           $(this).addClass('showfilter');
           
       }else if($(this).hasClass('showfilter')){
           $('.ctxs').css('position', 'absolute');
           $('.ctxs').css('left', '-250px');
           $(this).removeClass('showfilter');
           $(this).addClass('hiddenfilter');
       } 
    });
    
    
    
</script>
@endsection