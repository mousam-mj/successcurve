
@extends('layout')

@section('title')
Add Paragraph
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
                <span class="dash-header-title">Add Paragraph</span>
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
                <form action="{{URL('admin/qns/addPara')}}" method="post" enctype="multipart/form-data">
                @csrf

                  <input type="hidden" name="qlId" value="{{ $qls->qlId }}">
                    <div class="form-group">
                        <label for="paragraph" class="ds-label"><i class="fas fa-clipboard"></i> Paragraph</label>
                         <textarea class="form-control" id="paragraph" name="paragraph" placeholder="Paragraph"></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-custom3 form-control">Add Paragraph</button>
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
var editor = CKEDITOR.replace( 'paragraph' );
CKFinder.setupCKEditor( editor );
</script>
<script>
//CKEDITOR.replace( 'question' );
//CKEDITOR.replace( 'hint' );

</script>


@endsection

@section('javascript')
<script>

</script>
@endsection
