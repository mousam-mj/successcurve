
@extends('layout')

@section('title')
Edit Course
@endsection

@php
$subject = '';
$cls = '';
$ins = '';
$ins2 = '';
@endphp
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
                <h3 class="dash-header-title">Edit Course</h3>
            </div>
            <div class="dash-form-box">
                <form action="{{URL('admin/editCoursesContent')}}" method="post" enctype="multipart/form-data">
                @csrf
                   @foreach($courses as $course)
                    @php
                    $subject = $course->courseSubject;
                    $cls = $course->courseClass;
                    $ins = $course->courseInstructor1;
                    
                    if($course->courseInstructor2==''){
                        $ins2 = 0;
                    }else{
                        $ins2 = $course->courseInstructor2;
                    }
                    $status = $course->courseStatus;
                    @endphp
                    
                    <div class="form-group">
                        <label for="status" class="ds-label"><i class="fas fa-book"></i> Course Status</label>
                        <select name="status" class="form-control" id="status" required>
                            <option value="Pending" <?php if($status == 'Pending'){echo 'selected';} ?> >Pending</option>
                            <option value="Published" <?php if($status == 'Published'){echo 'selected';} ?> >Published</option>
                            <option value="Removed" <?php if($status == 'Removed'){echo 'selected';} ?> >Removed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="courseId" value="{{$course->courseId}}">
                        <label for="name" class="ds-label"><i class="fas fa-clipboard"></i> Course Title</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{$course->courseTitle}}" required>
                    </div>
                    <div class="form-group">
                        <label for="coursecode" class="ds-label"><i class="fas fa-code"></i> Course Code</label>
                        <input type="text" class="form-control" name="coursecode" id="coursecode" value="{{$course->courseCode}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="subject" class="ds-label"><i class="fas fa-book"></i> Subject</label>
                        <select name="subject" class="form-control" id="subject" required>
                            <option value="0">Select Subject</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cls" class="ds-label"><i class="fas fa-book"></i> Class</label>
                        <select name="cls" class="form-control" id="cls" required>
                            <option value="0">Select Class</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="instructor" class="ds-label"><i class="fas fa-user-plus"></i> Add Instructor</label>
                        <select name="instructor" class="form-control" id="instructor">
                            <option value="0">Select Instructor</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="instructor2" class="ds-label"><i class="fas fa-user-plus"></i> Add Instructor2 (optional)</label>
                        <select name="instructor2" class="form-control" id="instructor2">
                            <option value="0">Select Instructor2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        
                        <label for="description" class="ds-label"><i class="fas fa-info-circle"></i> Course Desription</label>
                        <textarea class="form-control" id="summary-ckeditor" name="description">{{$course->courseDescription}}</textarea>
                    </div>
                    <div>
                        <label for="course-avialability" class="ds-label"></label>
                    </div>
                    <div class="form-group">
                        <label for="image" class="ds-label"><i class="far fa-image"></i> Thumbnail</label>
                        <input type="file" class="form-control" name="image" id="image">
                        <input type="hidden" name="prevImage" value="{{$course->courseThumbnail}}">
                        <p class="text-danger mt-20">Current Thumbnail : <img src="{{ URL::asset($course->courseThumbnail) }}" class="cur-img" alt=""></p>
                    </div>
                    @endforeach
                    <div class="form-group">
                        <button type="submit" class="btn btn-custom3 form-control">Create Course</button>
                    </div>
                    <input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
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
//        console.log(dataResult);
        var resultData = dataResult.data;
        var bodyData = '';
        $.each(resultData,function(index,row){
            var subject = <?php echo $subject; ?>;
            //console.log(subject);
                var sid = row.subjectId;
            //console.log(sid);
                if(subject == sid){
                    bodyData+="<option value="+ row.subjectId +" selected>"+ row.subjectName +"</option>";
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
                var cls = <?php echo $cls; ?>;
                var cid = row.classId;
                if(cls == cid){
                    bodyData+="<option value="+ row.classId +" selected>"+ row.className +"</option>";
                }else{
                    bodyData+="<option value="+ row.classId +">"+ row.className +"</option>";

                } 
            })
            $("#cls").append(bodyData);
        }
    });
    $.ajax({
        url: "{{ URL('getInstructor')}}",
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
                var ins = <?php echo $ins; ?>;
//                console.log('instrsb2' + ins2);

                var insId = row.id;
                if(ins == insId){
                    bodyData+="<option value="+ row.id +" selected>"+ row.name +"</option>";
                }else{
                    bodyData+="<option value="+ row.id +">"+ row.name +"</option>";
                } 
            })
            $("#instructor").append(bodyData);
        }
    });
    $.ajax({
        url: "{{ URL('getInstructor')}}",
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
                var ins2 = <?php echo $ins2; ?>;
//                console.log('instrsb2' + ins2);

                var ins2Id = row.id;
                if(ins2 == ins2Id){
                    bodyData+="<option value="+ row.id +" selected>"+ row.name +"</option>";
                }else{
                    bodyData+="<option value="+ row.id +">"+ row.name +"</option>";
                } 
            })
            $("#instructor2").append(bodyData);
        }
    });

});
</script>
@endsection
