
@extends('layout')
@section('title')
Doubt Section
@endsection
@section('content')

<div class="main-box">
    <div  class="row">
        <div class="col-md-3 col-12 s-menu">
            
            <div class="s-dash">
                <div class="d-img">
                    <img src= "{{ URL::asset(Session::get('userImage')) }}" alt="{{Session::get('userImage')}}" class="ds-img">
                </div>
                  <div class="s-cont">
                    <h3 class="ds-name">{{Session::get('user')}} </h3>
                      <p class="ds-p">{{Session::get('userEmail')}}</p>
                  </div>
              </div>
            @include('Student.sidebar')
        </div>
          
        <div class="col-md-9 col-12 dash-container">
            <div class="row">
                <div class="col-md-9">
                    <div class="db-main">
                        
                        <div class="db-body">
                            <div class="doubts-main">
                                <div class="doubts-items mt-30">
                                    <div class="doubts-items mt-30">
                                        <div class="card">
                                          <div class="card-header">
                                            <span class="float-left">
                                                <h6>{{ $mydoubts->userName }}</h6>
                                              </span>
                                              <span class="float-right">
                                                <h6>{{ $mydoubts->updated_at }}</h6>
                                              </span>
                                            </div>
                                          <div class="card-body">
                                              {!! $mydoubts->doubtContent !!}
                                              <br/>
                                              @if($mydoubts->doubtImage)
                                                <a href="{{ asset($mydoubts->doubtImage) }}">
                                                    <img src="{{ asset($mydoubts->doubtImage) }}" alt="" class="dbtimg">
                                              </a>
                                              @endif

                                          </div>
                                          <div class="card-footer text-muted text-center">
                                                <span class="float-left">{{ $mydoubts->answers }} Answers</span>
                                              <span class="float-right">
                                                <a class="btn btn-sm btn-primary text-white" href="{{ url('student/singleDoubt/'.$mydoubts->doubtId) }}">Give Answer</a>
                                              </span>
                                          </div>
                                        </div>
                                    </div>
                                        
                                        
                                        
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
                <div  class="col-md-3">
                    <div class="adsec">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
     
</div>


<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
CKEDITOR.replace( 'dcontent' );  
    
</script>

@endsection

@section('javascript')

<script>
$(document).ready(function() {
       
});
</script>
@endsection
