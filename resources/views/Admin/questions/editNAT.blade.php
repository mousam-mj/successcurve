
@extends('layout')

@section('title')
Update NAT Question
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
                <span class="dash-header-title">Update NAT Question</span>

                <span style="float: right;">
                    <a class="btn btn-primary" href="{{ url('admin/qns/'.$qls->qlId) }}">Go Back</a>
                </span>
            </div>
            @if(Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>{{ Session::get('success') }}!</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
            @endif
            {{-- <div class="dash-form-box"> --}}
                <form action="{{URL('admin/qns/nat/updateQns')}}" method="post" enctype="multipart/form-data">
                @csrf

                  <input type="hidden" name="qlId" value="{{ $qls->qlId }}">
                  <input type="hidden" name="qwId" value="{{ $qls->qwId }}">
                    <div class="form-group">
                        <label for="question" class="ds-label"><i class="fas fa-clipboard"></i> Question</label>
                         <textarea class="form-control" id="question" name="question" placeholder="Question">{!! $qls->qwTitle !!}</textarea>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group pl-10">
                                    <label for="level" class="ds-label"><i class="fas fa-clipboard"></i> Difficulty Level</label>
                                    <select name="level" id="level" class="form-control">

                                        <option value="easy" 
                                         @if($qls->qwLevel == 'easy')
                                             {{'selected'}}
                                            @endif
                                        >Easy</option>
                                        <option value="midium"
                                         @if($qls->qwLevel == 'medium')
                                             {{'selected'}}
                                            @endif
                                        >Midium</option>
                                        <option value="hard"
                                         @if($qls->qwLevel == 'hard')
                                             {{'selected'}}
                                            @endif
                                        >Hard</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group pr-10">
                                    <label for="correctAns" class="ds-label"><i class="fas fa-clipboard"></i> Correct Answer</label>
                                    <input class="form-control" id="correctAns" name="correctAns" placeholder="Correct Answer" value="{{ $qls->qwCorrectAnswer }}">
                                </div>
                            </div>
                            div class="col-md-6">
                                <div class="form-group pr-10">
                                    <label for="minAns" class="ds-label"><i class="fas fa-clipboard"></i> Min Value</label>
                                    <input class="form-control" id="minAns" name="minAns" placeholder="Min Range">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group pr-10">
                                    <label for="maxAns" class="ds-label"><i class="fas fa-clipboard"></i> Max Value</label>
                                    <input class="form-control" id="maxAns" name="maxAns" placeholder="Max Range">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hint" class="ds-label"><i class="fas fa-info-circle"></i> Question Solution</label>
                        <textarea class="form-control" id="hint" name="hint" required>{!!$qls->qwHint!!}</textarea>
                    </div>


                    <div class="form-group">
                        <button type="submit" class="btn btn-custom3 form-control">Update NAT Question</button>
                    </div>
                </form>
            {{-- </div> --}}
      <!--        Container End   -->
        </div>




    </div>

</div>

<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('ckfinder/ckfinder.js') }}"></script>
<script>
var editor = CKEDITOR.replace( 'question' );
CKFinder.setupCKEditor( editor );
editor = CKEDITOR.replace( 'hint' );
CKFinder.setupCKEditor( editor );
</script>
<script>
//CKEDITOR.replace( 'question' );
//CKEDITOR.replace( 'hint' );

</script>


@endsection

@section('javascript')
<script>
$(document).ready(function() {
    
});
</script>
@endsection
