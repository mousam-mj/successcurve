
@extends('layout')

@section('title')
Create Course
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
                <h3 class="dash-header-title">Add New Course</h3>
            </div>
            {{-- <div class="dash-form-box"> --}}
                <form action="{{URL('admin/courses/add')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="form-group">
                        <label for="name" class="ds-label"><i class="fas fa-clipboard"></i> Course Title</label>
                        <input type="text" class="form-control" name="name" id="name" value="@if(Session::get('name')){{ Session::get('name') }}
                            @endif" required>
                    </div>
                    <div class="form-group">
                        <label for="name" class="ds-label"><i class="fas fa-clipboard"></i> Course URI</label>
                        <input type="text" class="form-control" name="uri" id="uri" value="@if(Session::get('uri')){{ Session::get('uri') }}
                            @endif" required>
                    </div>
                    <div class="form-group">
                        <label for="coursecode" class="ds-label"><i class="fas fa-code"></i> Course Code</label>
                        <input type="text" class="form-control" name="coursecode" id="coursecode" value="@if(Session::get('courseCode')){{ Session::get('courseCode') }}
                            @endif" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="subject" class="ds-label"><i class="fas fa-book"></i> Subject</label>
                                <select name="subject" class="form-control" id="subject" required>
                                    <option value="0">Select Subject</option>
                                    @if(Session::get('subjects'))
                                    <option value="{{ Session::get('subjects') }}" selected>{{ Session::get('subjectName') }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 pl-10">
                            <div class="form-group">
                                <label for="cls" class="ds-label"><i class="fas fa-book"></i> Class</label>
                                <select name="cls" class="form-control" id="cls" required>
                                    <option value="0">Select Class</option>
                                    @if(Session::get('clss'))
                                    <option value="{{ Session::get('clss') }}" selected>{{Session::get('clsName')}}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="instructor" class="ds-label"><i class="fas fa-user-plus"></i> Add Instructor</label>
                                <select name="instructor" class="form-control" id="instructor">
                                    <option value="0">Select Instructor</option>
                                    @if(Session::get('instructor')>0)
                                    <option value="{{ Session::get('instructor') }}" selected>{{ Session::get('instructorName') }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 pl-10">
                            <div class="form-group">
                                <label for="instructor2" class="ds-label"><i class="fas fa-user-plus"></i> Add Instructor2 (optional)</label>
                                <select name="instructor2" class="form-control" id="instructor2">
                                    <option value="0">Select Instructor</option>
                                    @if(Session::get('instructor2')>0)
                                    <option value="{{ Session::get('instructor2') }}" selected>{{ Session::get('instructorName2') }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="price" class="ds-label"><i class="fas fa-usd-square"></i> Price</label>
                            <input type="number" name="price" id="price" class="form-control" placeholder="Price">
                        </div>
                        <div class="col-md-6 pl-10">
                            <label for="validity" class="ds-label"><i class="fas fa-user-clock"></i> Validity</label>
                            <input type="number" name="validity" id="validity" class="form-control" placeholder="Validity in Months">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="ds-label"><i class="fas fa-info-circle"></i> Course Desription</label>
                        <textarea class="form-control" id="summary-ckeditor" name="description">@if(Session::get('description'))
                            {{ Session::get('description') }}
                            @endif</textarea>
                    </div>
                    <div>
                        <label for="course-avialability" class="ds-label"></label>
                    </div>
                    <div class="form-group">
                        <label for="image" class="ds-label"><i class="far fa-image"></i> Thumbnail</label>
                        <input type="file" class="form-control" name="image" id="image" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="metakey" class="ds-label">Meta Keyword</label>
                        <textarea name="metakey" id="metakey" cols="5" class="form-control"></textarea>
                    </div>                    
                    <div class="form-group">
                        <label for="metadesc" class="ds-label">Meta Description</label>
                        <textarea name="metadesc" id="metadesc" cols="5" class="form-control"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-custom3 form-control">Create Course</button>
                    </div>
                </form>
            {{-- </div>         --}}
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
        console.log(dataResult);
        var resultData = dataResult.data;
        var bodyData = '';
        $.each(resultData,function(index,row){
                bodyData+="<option value="+ row.subjectId +">"+ row.subjectName +"</option>";

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
            console.log(dataResult);
            var resultData = dataResult.data;
            var bodyData = '';
            $.each(resultData,function(index,row){
                bodyData+="<option value="+ row.classId +">"+ row.className +"</option>";

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
            console.log(dataResult);
            var resultData = dataResult.data;
            var bodyData = '';
            $.each(resultData,function(index,row){
                bodyData+="<option value="+ row.id +">"+ row.name +"</option>";

            })
            $("#instructor").append(bodyData);
            $("#instructor2").append(bodyData);
        }
    });
    $("#name").on("keyup", function(){
        $("#uri").val(generateSlug($(this).val()));
    });


});

function generateSlug(text){
    return text.toLowerCase().replace(/ /g,'-').replace(/[-]+/g, '-').replace(/[^\w-]+/g,'');
}
</script>
@endsection
