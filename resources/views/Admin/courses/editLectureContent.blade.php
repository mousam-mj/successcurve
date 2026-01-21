
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
            @if(Session::get('sucess'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>{{Session::get('sucess')}}</strong> 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
            @endif
            <div class="dash-header">
                <h3 class="dash-header-title">Edit Lecture</h3>
            </div>
            <div class="dash-form-box">
                <form action="{{URL('admin/updateLecture')}}" method="post">
                @csrf
                    @foreach( $courses as $data)
                    
                    
                    <div class="form-group">
                        <label for="name" class="ds-label"><i class="fas fa-clipboard"></i> Lecture Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{$data->lectureTitle}}" required>
                        
                        <input type="hidden" value="{{$data->lectureId}}" name="lectureId">
                        <input type="hidden" value="{{$data->courseId}}" name="courseId">
                        <input type="hidden" value="{{$data->weekId}}" name="weekId">
                    </div>
                    <div class="form-group">
                        <label for="video" class="ds-label"><i class="fas fa-clipboard"></i> Lecture Video</label>
                        <input type="text" class="form-control" name="video" id="video" value="{{$data->lectureVideo}}">
                    </div>
                    
                    <div class="form-group">
                        <label for="description" class="ds-label"><i class="fas fa-info-circle"></i> Course Desription</label>
                        <textarea class="form-control" id="summary-ckeditor" name="description">{{$data->lectureContent}}</textarea>
                    </div>
                    @endforeach
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
<script>
CKEDITOR.replace( 'summary-ckeditor' );  
    
</script>
@endsection

@section('javascript')

@endsection