
@extends('layout')
@section('title')
Lectures | {{ $modules->weekName }}
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

        <div class="col-md-9 col-12 dash-container">

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

            <div class="card">
              <div class="card-header">
                <h3 class="card-title" style="float: left;">Lectures : {{ $modules->weekName }}</h3>

                <div class="card-tools" style="float: right;">
                    <a class="btn btn-primary btn-sm" href="{{ url('faculty/lectures/new/'.$modules->weekId) }}">Add New</a>
                </div>
              </div>

              <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Lecture</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count=1; ?>
                            @foreach($lectures as $course)
                                <tr>
                                    <td>{{ $course->lectureId }}</td>
                                    <td>
                                        @if ($course->lectureType == 0)
                                        {!! $course->lectureTitle !!}
                                        @elseif ($course->lectureType == 1)
                                        <a href="{{ url('faculty/lecture/qns/'.$course->lectureId) }}" class="text-danger" style="font-weight: 500;">{{ $course->lectureTitle }}</a>
                                        @endif
                                        
                                    </td>
                                   
                                    <td class="text-center">
                                        <a class="text-info btn-sm" href="{{ url('faculty/lecture/edit/'. $course->lectrureId) }}">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a class="text-danger btn-sm" href="{{ url('faculty/lecture/remove/'.$course->lectrureId) }}">
                                            <i class="far fa-trash-alt"></i>
                                        </a>

                                    </td>
                                </tr>
                            <?php $count++;?>
                            @endforeach
                        </tbody>
                    </table>
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
<script>
$(document).ready(function() {
    $('#dataTables-example1').DataTable({
            responsive: true
    });


});

</script>

@endsection
