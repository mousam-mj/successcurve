
@extends('layout')

@section('title')
Add Instructions
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
                <h3 class="dash-header-title">Update Instructions</h3>
            </div>
            <div class="dash-form-box">
                <form action="{{URL('admin/updateInstruction')}}" method="post" enctype="multipart/form-data">
                @csrf
                    @foreach($ins as $in)
                    
                    <input type="hidden" name="id" value="{{ $in->inId }}">
                    
                    <div class="form-group">
                        <label for="name" class="ds-label"><i class="fas fa-clipboard"></i> Instruction Title</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ $in->inTitle }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description" class="ds-label"><i class="fas fa-info-circle"></i> Instruction Desription</label>
                        <textarea class="form-control" id="summary-ckeditor" name="description">{{ $in->inDescription }}</textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-custom3 form-control">Update Instruction</button>
                    </div>
                    @endforeach
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

@endsection
