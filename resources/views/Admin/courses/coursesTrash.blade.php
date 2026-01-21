
@extends('layout')
@section('title')
Courses
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
                <h3 class="card-title" style="float: left;">Trash Courses</h3>

              </div>

              <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Course</th>
                                <th>Class</th>
                                <th>Price</th>
                                <th>Instructor</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count=1; ?>
                            @foreach($courses as $course)
                                <tr>
                                    <td>{{ $course->courseId }}</td>
                                    <td>
                                        <a href="{{ url('admin/courses/modules/'.$course->courseId) }}" class="text-info">
                                            {!! $course->courseTitle !!}
                                        </a>
                                    </td>
                                    <td>{!! $course->className !!}</td>
                                    <td>
                                        @if ($course->coursePrice != null) 
                                            <a href="{{ url('admin/courses/payments/'. $course->courseId )}}"> {{ $course->coursePrice }} </a>
                                        @else
                                            Free
                                        @endif
                                    </td>
                                    <td>{!! $course->name !!}</td>
                                    <td class="text-center">
                                        <a class="text-info btn-sm" href="{{ url('admin/courses/edit/'. $course->courseId) }}">
                                            <i class="far fa-edit"></i>
                                        </a>

                                        <a class="text-success btn-sm" href="{{ url('admin/courses/restore/'.$course->courseId) }}" >
                                            <i class="fas fa-trash-undo-alt"></i>
                                        </a>

                                        <a class="text-danger btn-sm" href="{{ url('admin/courses/delete/'.$course->courseId) }}" onclick="return confirm('Are you sure? want to delete this..');">
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
              <div class="card-footer">
                <a href="{{ url('admin/courses') }}" class="text-primary">Courses</a>
              </div>
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
