
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
                        <div class="db-head">
                            <nav class="pdo">
                              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link dblink active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">All</a>
                                <a class="nav-item nav-link dblink" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">My Doubts</a>
                                <a class="nav-item nav-link dblink" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Ask Doubts</a>
                              </div>
                            </nav>
                            <div class="dfilter">
                                <form class="dfilter">
                                @csrf
                                    <select id="subject" name="subject" class="filselect">
                                        <option value="0">--Select Subject--</option>
                                    </select>
                                    <select id="cls" name="cls" class="filselect">
                                        <option value="0">--Select Class--</option>
                                    </select>
                                    <button type="submit" class="filsubBtn">Apply</button>
                                    <a class="clfil" href="">Clear</a>
                                </form>
                            </div>
                        </div>
                        <div class="db-body">
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <div class="doubts-main">
                                        @foreach($doubts as $doubt)
                                        <div class="doubts-items mt-30">
                                            <div class="card">
                                              <div class="card-header">
                                                <span class="float-left">
                                                    <h6>{{ $doubt->userName }}</h6>
                                                  </span>
                                                  <span class="float-right">
                                                    <h6>{{ $doubt->updated_at }}</h6>
                                                  </span>
                                                </div>
                                              <div class="card-body">
                                                  {!! $doubt->doubtContent !!}
                                                  <br/>
                                                  @if($doubt->doubtImage)
                                                    <a href="{{ asset($doubt->doubtImage) }}">
                                                        <img src="{{ asset($doubt->doubtImage) }}" alt="" class="dbtimg">
                                                  </a>
                                                  @endif
                                                  
                                              </div>
                                              <div class="card-footer text-muted text-center">
                                                    <span class="float-left">{{ $doubt->answers }} Answers</span>
                                                  <span class="float-right">
                                                    <a class="btn btn-sm btn-primary text-white" href="{{ url('student/singleDoubt/'.$doubt->doubtId) }}">Give Answer</a>
                                                  </span>
                                              </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <div class="doubts-main">
                                         @foreach($mydoubts as $mydoubt)
                                       <div class="doubts-items mt-30">
                                            <div class="card">
                                              <div class="card-header">
                                                <span class="float-left">
                                                    <h6>{{ $mydoubt->userName }}</h6>
                                                  </span>
                                                  <span class="float-right">
                                                    <h6>{{ $mydoubt->updated_at }}</h6>
                                                  </span>
                                                </div>
                                              <div class="card-body">
                                                  {!! $mydoubt->doubtContent !!}
                                                  <br/>
                                                  @if($mydoubt->doubtImage)
                                                    <a href="{{ asset($mydoubt->doubtImage) }}">
                                                        <img src="{{ asset($mydoubt->doubtImage) }}" alt="" class="dbtimg">
                                                  </a>
                                                  @endif
                                                  
                                              </div>
                                              <div class="card-footer text-muted text-center">
                                                    <span class="float-left">{{ $mydoubt->answers }} Answers</span>
                                                  <span class="float-right">
                                                    <a class="btn btn-sm btn-primary text-white" href="{{ url('student/singleDoubt/'.$mydoubt->doubtId) }}">Give Answer</a>
                                                  </span>
                                              </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                    <div class="doubts-main">
                                        <form class="form-group" action="{{ url('student/askDoubt') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="card">
                                              
                                              <div class="card-body">
                                                  
                                                <div class="form-group">
                                                    <label for="dsub" class="ds-label">Subject</label>
                                                    <select class="form-control" id="dsub" name="dsub">
                                                        <option value="0">-- Select Subject --</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="dcls" class="ds-label">Class</label>
                                                    <select class="form-control" id="dcls" name="dcls">
                                                        <option value="0">-- Select Class --</option>
                                                    </select>
                                                </div>
                                                  <div class="form-group">
                                                    <label for="dcontent" class="ds-label">Doubt</label>    
                                                      <textarea class="form-control" id="dcontent" class="form-control" name="dcontent" cols="5"></textarea>
                                                  </div>
                                                  <div class="form-group">
                                                    <label class="ds-label" for="image">Image</label>
                                                      <input type="file" class="form-control" name="image">
                                                  </div>
                                              </div>
                                              <div class="card-footer text-muted">
                                                    
                                                  <span class="float-right">
                                                    <button type="submit" class="btn btn-sm btn-primary text-white">Ask Doubt</button>
                                                  </span>
                                              </div>
                                            </div>
                                        </form>
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
                bodyData+="<option value="+ row.subjectId +">"+ row.subjectName +"</option>";

            })
            $("#subject").append(bodyData);
            $("#dsub").append(bodyData);
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
                bodyData+="<option value="+ row.classId +">"+ row.className +"</option>";

            })
            $("#cls").append(bodyData);
            $("#dcls").append(bodyData);
        }
    });
});
</script>
@endsection
