
@extends('layout')
@section('title')
Add Week
@endsection
@section('content')

<div class="main-box">
    <div  class="row">
        <div class="col-md-3 col-12 s-menu">
            
            <div class="s-dash">
                <div class="d-img">
                    <img src= "{{ URL::asset(Session::get('fuserImage')) }}" alt="{{Session::get('fuserImage')}}" class="ds-img">
                </div>
                  <div class="s-cont">
                    <h3 class="ds-name">{{Session::get('fuser')}} </h3>
                      <p class="ds-p">{{Session::get('fuserEmail')}}</p>
                  </div>
              </div>
            @include('Faculty.sidebar')    
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
                <h3 class="dash-header-title">Add New Module</h3>
            </div>
            <div class="dash-form-box">
                <form action="{{URL('faculty/addWeek')}}" method="post">
                @csrf
                    <div class="form-group">
                        <label for="course" class="ds-label"><i class="fas fa-book"></i> Course</label>
                        <select name="course" class="form-control" id="course" required>
                            <option value="0">Select Course</option>
                            
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name" class="ds-label"><i class="fas fa-clipboard"></i> Module Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-custom3 form-control">Add Week/Section</button>
                    </div>
                </form>
            </div>        
      <!--        Container End   -->  
        </div>
        
        
        
        
    </div>
    
</div>

@endsection

@section('javascript')
<script>
$(document).ready(function(){
    $.ajax({
        url: "{{ URL('faculty/getCourses')}}",
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
                @if(Session::get('courseId'))
                bodyData+="<option value="+ row.courseId +" selected>"+ row.courseTitle +"</option>";
                @else                    
                bodyData+="<option value="+ row.courseId +">"+ row.courseTitle +"</option>";
                @endif
            })
            $("#course").append(bodyData);
        }
    }); 
});
</script>

@endsection