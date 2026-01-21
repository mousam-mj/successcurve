
@extends('layout')
@section('title')
Add Lecture
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
                <h3 class="dash-header-title">Add New Lecture</h3>
            </div>
            <div class="dash-form-box">
                <form action="{{URL('admin/addLecture')}}" method="post">
                @csrf
                    <input type="hidden" name="courseId" value="{{ $modules->courseId }}">
                    <input type="hidden" name="moduleId" value="{{ $modules->weekId }}">
                    <div class="form-group">
                        <label for="name" class="ds-label"><i class="fas fa-clipboard"></i> Lecture Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="type" class="ds-label"><i class="fas fa-clipboard"></i> Lecture Type</label>
                        <select name="type" id="type" class="form-control">
                            <option value="0">Lecture</option>
                            <option value="1">Practice Quiz</option>
                        </select>
                    </div>
                    <div id="lecbx">
                        <div class="form-group">
                            <label for="video" class="ds-label"><i class="fas fa-clipboard"></i> Lecture Video</label>
                            <input type="text" class="form-control" name="video" id="video" >
                        </div>
                        
                        <div class="form-group">
                            <label for="description" class="ds-label"><i class="fas fa-info-circle"></i> Lecture Desription</label>
                            <textarea class="form-control" id="summary-ckeditor" name="description"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-custom3 form-control">Add Lecture</button>
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
    $('#type').change(function(){
        if($(this).val() == 0){
            $('#lecbx').show();
        }else if($(this).val() == 1){
            $('#lecbx').hide();
        }
    });
});
</script>

@endsection