
@extends('layout')
@section('title')
Edit Lecture
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
            @if(Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>{{ Session::get('success') }}!</strong> 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @endif
            <div class="dash-header">
                <h3 class="dash-header-title">Edit Lecture</h3>
            </div>
            <div class="dash-form-box">
                <form action="{{URL('admin/editLecture2')}}" method="post">
                @csrf
                    <div class="form-group">
                        <label for="course" class="ds-label"><i class="fas fa-book"></i> Course</label>
                        <select name="course" class="form-control" id="course" required>
                            <option value="0">Select Course</option>
                            @foreach( $courses as $course)
                            <option value="{{$course->courseId}}">{{$course->courseTitle}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="week" class="ds-label"><i class="fas fa-book"></i> Module</label>
                        <select name="week" class="form-control" id="week" required>
                            <option value="0">Select Module</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lecture" class="ds-label"><i class="fas fa-book"></i> Lecture</label>
                        <select name="lecture" class="form-control" id="lecture" required>
                            <option value="0">Select Lecture</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-custom3 form-control">Update Lecture</button>
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
   var editor = CKEDITOR.replace( 'summary-ckeditor' );
CKFinder.setupCKEditor( editor ); 
    
</script>
@endsection

@section('javascript')
<script>
$(document).ready(function(){
    function changeCourse(){
        $('#course').change(function(){
            var d = $(this).val();
            $.ajax({
                url: "{{ URL('getWeek')}}",
                type: "POST",
                data:{ 
                    _token:'{{ csrf_token() }}',
                    courseId: d,
                },
                cache: false,
                dataType: 'json',
                success: function(dataResult){

                    var resultData = dataResult.data;
                    var bodyData = '<option value="0">Select Module</option>';
                    $.each(resultData,function(index,row){

                        bodyData+="<option value="+ row.weekId +">"+ row.weekName +"</option>";

                    })
                    $("#week").html(bodyData);
                    changeWeek();
                }
            }); 
        });
    }
    function changeWeek(){
        $('#week').change(function(){
        var w = $(this).val();
        $.ajax({
            url: "{{ URL('getLecs')}}",
            type: "POST",
            data:{ 
                _token:'{{ csrf_token() }}',
                weekId: w,
            },
            cache: false,
            dataType: 'json',
            success: function(dataResult){
                console.log(dataResult);
                var resultData = dataResult.data;
                var bodyData = '<option value="0">Select Lecture</option>';
                $.each(resultData,function(index,row){
                    
                    bodyData+="<option value="+ row.lectureId +">"+ row.lectureTitle +"</option>";
                })
                $("#lecture").html(bodyData);
            }
        }); 
    });
    }
    
    changeCourse();
    changeWeek();
    
});
</script>

@endsection