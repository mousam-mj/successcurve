
@extends('layout')
@section('title')
Modules | {{ $crs->courseTitle }}
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
                <h3 class="card-title" style="float: left;">Modules : {{ $crs->courseTitle }}</h3>

                <div class="card-tools" style="float: right;">
                    <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModel">Add New</a>
                </div>
                <div class="modal fade" id="addModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Add Module</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{URL('admin/addModule')}}" method="post">
                                @csrf
                                    <input type="hidden" name="courseId" value="{{ $crs->courseId }}">
                                    <div class="form-group">
                                        <label for="name" class="ds-label"><i class="fas fa-clipboard"></i> Module Name</label>
                                        <input type="text" class="form-control" name="name" id="name" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-custom3 form-control">Add Module</button>
                                    </div>
                                </form>
                        </div>
                      </div>
                    </div>
                </div>

              </div>

              <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Modules</th>
                                
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count=1; ?>
                            @foreach($modules as $course)
                                <tr>
                                    <td>{{ $course->weekId }}</td>
                                    <td>
                                        <a href="{{ url('admin/courses/lectures/'.$course->weekId) }}" class="text-info">
                                            {!! $course->weekName !!}
                                        </a>
                                    </td>
                                   
                                    <td class="text-center">
                                        <a class="text-info btn-sm" href="{{ url('admin/modules/edit/'. $course->weekId) }}">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a class="text-danger btn-sm" href="{{ url('admin/modules/remove/'.$course->weekId) }}">
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
                <a href="{{ url('admin/Modules/trash') }}" class="text-danger">Deleted Modules</a>
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
