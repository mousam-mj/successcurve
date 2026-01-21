
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
                    <form action="{{ url('faculty/course/filter') }}" method="GET" class="form-inline">

                        <label class="sr-only" for="cls">Class</label>
                        <select class="form-control mb-2 mr-sm-2" id="cls" name="cls">
                            <option value="0">---- Choose Class -----</option>
                        </select>
                        
                        <label class="sr-only" for="subject">Subject</label>
                        <select class="form-control mb-2 mr-sm-2" id="subject" name="subject">
                            <option value="0">---- Choose Subject -----</option>
                        </select>
                      
                      
                        <button type="submit" class="btn btn-primary mb-2">Filter</button>
                      </form>
                </div>

              <div class="card-header">
                <h3 class="card-title" style="float: left;">Courses</h3>

                <div class="card-tools" style="float: right;">
                    <a class="btn btn-primary btn-sm" href="{{ url('faculty/courses/new/') }}">Add New</a>
                </div>
              </div>

              <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Course</th>
                                <th>Price</th>
                                <th>Class</th>
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
                                        <a href="{{ url('faculty/courses/modules/'.$course->courseId) }}" class="text-info">
                                            {!! $course->courseTitle !!}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($course->coursePrice != null) 
                                            <a href="{{ url('faculty/courses/payments/'. $course->courseId )}}"> {{ $course->coursePrice }} </a>
                                        @else
                                            Free
                                        @endif
                                    </td>
                                    <td>{!! $course->className !!}</td>
                                    <td>{!! $course->name !!}</td>
                                    <td class="text-center">
                                        <a class="text-info btn-sm" href="{{ url('faculty/courses/edit/'. $course->courseId) }}">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a class="text-danger btn-sm" href="{{ url('faculty/courses/remove/'.$course->courseId) }}">
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


$.ajax({
        url: "{{ URL('getClasses')}}",
        type: "POST",
        data:{ 
            _token:'{{ csrf_token() }}'
        },
        cache: false,
        dataType: 'json',
        success: function(dataResult){
            console.log(dataResult);
            var resultData = dataResult.data;
            var bodyData = '';
            $.each(resultData,function(index,row){
                bodyData+="<option value="+ row.classId +">"+ row.className +"</option>";

            })
            $("#cls").append(bodyData);
        }
    });

    $.ajax({
    url: "/getSubjects",
    type: "POST",
    data:{ 
        _token: '{{csrf_token()}}'
    },
    cache: false,
    dataType: 'json',
    success: function(dataResult){
        console.log(dataResult);
        var resultData = dataResult.data;
        var bodyData = '';
        $.each(resultData,function(index,row){
                bodyData+="<option value="+ row.subjectId +">"+ row.subjectName +"</option>";

            })
            $("#subject").append(bodyData);
        }
    });

</script>

@endsection
