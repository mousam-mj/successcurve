
@extends('layout')
@section('title')
Upload MCQ Question
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
        
        <div class="col-md-9 col-12 dash-container">
            
            
            <div class="card">
              <div class="card-header">
                <h3 class="card-title" style="float: left;">Upload MCQ Questions</h3>

                <div class="card-tools" style="float: right;">
                    <a class="btn btn-primary" href="{{ url('admin/addQuestion') }}">Add Question Manually</a>
                </div>
              </div>
                
              <div class="card-body">
                    <form method="post" action="{{ url('importMCQs') }}" enctype="multipart/form-data">
                        @csrf
                        <div  class="form-group">
                            <label class="ds-label" for="file">Upload Excel File</label>
                            <input type="file" name="file" class="form-control" id="file">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-sm" type="submit">Upload</button>
                        </div>
                    </form>
                </div>
                <!-- /.table-responsive -->

              </div>
              <!-- /.card-body -->
              
              <!-- /.card-footer-->
            </div>
            
            
        </div>
        
        
        
        
    </div>
    
</div>

@endsection

@section('javascript')

@endsection
