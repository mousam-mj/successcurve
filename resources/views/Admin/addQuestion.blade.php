
@extends('layout')

@section('title')
Add Question
@endsection


@section('content')

<div class="main-box">
    <div  class="row">
        <div class="col-md-3 col-12 s-menu">
            
            <div class="s-dash">
                <div class="d-img">
                    <img src= "{{ URL::asset(Session::get('auserImage')) }}" alt="{{Session::get('auserImage')}}" class="ds-img">
                </div>
                  <div class="s-cont">
                    <h3 class="ds-name">{{Session::get('auser')}} </h3>
                      <p class="ds-p">{{Session::get('auserEmail')}}</p>
                  </div>
              </div>
            @include('Admin.adminSidebar')    
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
                <h3 class="dash-header-title">Add Question</h3>
            </div>
            <div class="dash-form-box">
                <form action="{{URL('admin/addQuestion')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group pr-10">
                                    <label for="subject" class="ds-label"><i class="fas fa-clipboard"></i> Subject</label>
                                    <select name="subject" id="subject" class="form-control">
                                        <option value="0">Select Subject</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group pl-10">
                                    <label for="topic" class="ds-label"><i class="fas fa-clipboard"></i> Topic</label>
                                    <select name="topic" id="topic" class="form-control">
                                        <option value="0">Select Topic</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group pl-10">
                                    <label for="cls" class="ds-label"><i class="fas fa-book"></i> Class</label>
                                    <select name="cls" class="form-control" id="cls" required>
                                        <option value="0">Select Class</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group pl-10">
                                    <label for="tag" class="ds-label"><i class="fas fa-clipboard"></i> Question Tag</label>
                                    <select name="tag" id="tag" class="form-control">
                                        <option value="0">Select Tag</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group pr-10">
                                    <label for="questiontype" class="ds-label"><i class="fas fa-clipboard"></i> Question Type</label>
                                    <select name="questiontype" id="questiontype" class="form-control">
                                        <option value="0">Select Type</option>
                                        <option value="radio">Multiple Choice Single Answer</option>
                                        <option value="checkbox">Multiple Choice Multi Answer</option>
<!--
                                        <option value="0" disabled>Descriptive</option>
                                        <option value="blanks" disabled>Blanks</option>
-->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group pl-10">
                                    <label for="level" class="ds-label"><i class="fas fa-clipboard"></i> Difficulty Level</label>
                                    <select name="level" id="level" class="form-control">
                                        <option value="0">Select Level</option>
                                        <option value="easy">Easy</option>
                                        <option value="midium">Midium</option>
                                        <option value="hard">Hard</option>
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="marks" class="ds-label"><i class="fas fa-clipboard"></i>Marks</label>
                        <input type="number" class="form-control" name="marks" id="marks" required placeholder="Marks">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group pr-10">
                                    <label for="isNeg" class="ds-label"><i class="fas fa-clipboard"></i> Is Negative Marking</label>
                                    <select name="isNeg" id="isNeg" class="form-control">
                                        <option value="0">False</option>
                                        <option value="1">True</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group pl-10" id="negbox">
                                    <label for="negMarks" class="ds-label"><i class="fas fa-clipboard"></i> Negative Percent </label>
                                    <input type="number" name="negMarks" id="negMarks" class="form-control" placeholder="in percentage">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="question" class="ds-label"><i class="fas fa-clipboard"></i> Question</label>
                         <textarea class="form-control" id="question" name="question" placeholder="Question"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="totalOptions" class="ds-label">Total Options</label>
                        <input type="number" name="totalOptions" id="totalOptions" placeholder="Total Options" required class="form-control">
                    </div>
                    <div class="form-group">
                        <div class="row" id="optionRow">
                            
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group pr-10">
                                    <label for="correctAns" class="ds-label"><i class="fas fa-clipboard"></i> Correct Answer</label>
                                    <input class="form-control" id="correctAns" name="correctAns" placeholder="Correct Answer">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="hint" class="ds-label"><i class="fas fa-info-circle"></i> Question Solution</label>
                        <textarea class="form-control" id="hint" name="hint" required></textarea>
                    </div>
                    
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-custom3 form-control">Add Question</button>
                    </div>
                </form>
            </div>        
      <!--        Container End   -->  
        </div>
        
        
        
        
    </div>
    
</div>

<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('ckfinder/ckfinder.js') }}"></script>
<script>
var editor = CKEDITOR.replace( 'question' );
CKFinder.setupCKEditor( editor );
editor = CKEDITOR.replace( 'hint' );
CKFinder.setupCKEditor( editor );
</script>
<script>
//CKEDITOR.replace( 'question' );    
//CKEDITOR.replace( 'hint' );  
    
</script>


@endsection

@section('javascript')
<script>
$(document).ready(function() {
        
        
    $.ajax({
        url: "/getSubjects",
        type: "POST",
        data:{ 
            _token: '{{csrf_token()}}'
        },
        cache: false,
        dataType: 'json',
        success: function(dataResult){
//            console.log(dataResult);
            var resultData = dataResult.data;
            var bodyData = '';
            $.each(resultData,function(index,row){
                    bodyData+="<option value="+ row.subjectId +">"+ row.subjectName +"</option>";

                })
                $("#subject").append(bodyData);
        }
    }); 
    $('#subject').change(function(){
        var d = $(this).val();
        $.ajax({
            url: "{{ URL('admin/getTopics')}}",
            type: "POST",
            data:{ 
                _token:'{{ csrf_token() }}',
                subjectId: d,
            },
            cache: false,
            dataType: 'json',
            success: function(dataResult){
//                console.log(dataResult);
                var resultData = dataResult.data;
                var bodyData = '';
                $.each(resultData,function(index,row){
                    
                    bodyData+="<option value="+ row.stId +">"+ row.stName +"</option>";
                 
                })
                $("#topic").html(bodyData);
            }
        }); 
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
                bodyData+="<option value="+ row.classId +">"+ row.className +"</option>";
            })
            $("#cls").append(bodyData);
        }
    });
    $.ajax({
            url: "{{ URL('admin/getQuestionTags')}}",
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
                    
                    bodyData+="<option value="+ row.qtId +">"+ row.qtName +"</option>";
                 
                })
                $("#tag").html(bodyData);
            }
        }); 
    $("#totalOptions").change(function() {
        var nos = $(this).val();
        var i;
        var bodydata = '';
        for(i=1; i<=nos; i++){
//            console.log(i);
            bodydata+= '<div class="col-md-6"><div class="form-group pr-10">                                    <label for="option'+ i +'" class="ds-label"><i class="fas fa-clipboard"></i> Option'+ i +'</label>                                    <textarea class="form-control ckeditor" id="option'+ i +'" name="option'+ i +'" placeholder="Option '+ i +'"></textarea>                                </div>                            </div>';
            
        }
        $('#optionRow').html(bodydata);
        for(i=1; i<=nos; i++){
//        CKEDITOR.replace('option'+i);
       var editor = CKEDITOR.replace( 'option'+i );
            CKFinder.setupCKEditor( editor );
        }
    });
     $('#negbox').hide();

    $('#isNeg').change(function(){
        var data = $(this).val();
        
        if(data == 1){
            $('#negbox').show();
       }
        else if(data ==0){
            $('#negMarks').val(0.00);
            $('#negbox').hide();
        }
    });
});
</script>
@endsection
