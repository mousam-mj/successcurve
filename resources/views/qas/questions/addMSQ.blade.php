
@extends('layout')

@section('title')
Add MSQ Question
@endsection


@section('content')

<div class="main-box">
    <div  class="row">
        <div class="col-md-3 col-12 s-menu">

            <div class="s-dash">
                <div class="d-img">
                    <img src= "{{ URL::asset(Session::get('qaImage')) }}" alt="{{Session::get('qaImage')}}" class="ds-img">
                </div>
                  <div class="s-cont">
                    <h3 class="ds-name">{{Session::get('qaUser')}} </h3>
                      <p class="ds-p">{{Session::get('qaEmail')}}</p>
                  </div>
              </div>
            @include('qas.sidebar')
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
                <span class="dash-header-title">Add MSQ Question</span>

                <span style="float: right;">
                    <a class="btn btn-primary" href="{{ url('qas/qns/'.$qls->qlId) }}">Go Back</a>
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
                <form action="{{URL('qas/qns/msq/addQns')}}" method="post" enctype="multipart/form-data">
                @csrf

                  <input type="hidden" name="qlId" value="{{ $qls->qlId }}">
                    <div class="form-group">
                        <label for="question" class="ds-label"><i class="fas fa-clipboard"></i> Question</label>
                         <textarea class="form-control" id="question" name="question" placeholder="Question"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group pl-10">
                                    <label for="level" class="ds-label"><i class="fas fa-clipboard"></i> Difficulty Level</label>
                                    <select name="level" id="level" class="form-control">

                                        <option value="easy" selected>Easy</option>
                                        <option value="midium">Midium</option>
                                        <option value="hard">Hard</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6" id="ttlop">
                                <div class="form-group">
                                    <label for="totalOptions" class="ds-label">Total Options</label>
                                    <input type="number" name="totalOptions" id="totalOptions" placeholder="Total Options"  class="form-control">
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row" id="optionRow">

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group pr-10">
                                    <label for="correctAns" class="ds-label"><i class="fas fa-clipboard"></i> Correct Answer</label>
                                    <input class="form-control" id="correctAns" name="correctAns" placeholder="1,2,3">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="hint" class="ds-label"><i class="fas fa-info-circle"></i> Question Solution</label>
                        <textarea class="form-control" id="hint" name="hint" required></textarea>
                    </div>


                    <div class="form-group">
                        <button type="submit" class="btn btn-custom3 form-control">Add MSQ Question</button>
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
    $("#totalOptions").change(function() {
        var nos = $(this).val();
        var i;
        var bodydata = '';
        for(i=1; i<=nos; i++){
//            console.log(i);
            bodydata+= '<div class="col-md-6"><div class="form-group pr-10">                                    <label for="option'+ i +'" class="ds-label"><i class="fas fa-clipboard"></i> Option'+ i +'</label>                                    <textarea class="form-control ckeditor" id="option'+ i +'" name="option'+ i +'" placeholder="Option '+ i +'"></textarea>                                </div>                            </div>';

        }
        $('#optionRow').html(bodydata);
        for(i=1; i<=nos; i++){
//        CKEDITOR.replace('option'+i);
       var editor = CKEDITOR.replace( 'option'+i );
            CKFinder.setupCKEditor( editor );
        }
    });
});
</script>
@endsection
