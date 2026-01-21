
@extends('layout')
@section('title')
Create Test
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
            @if($success)
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>{{ $success }}!</strong> 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
            @endif
            
            <div class="card">

                <div class="card-header">
                    <form action="{{ url('admin/tests/filter') }}" method="GET" class="form-inline">

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
                <h3 class="card-title" style="float: left;">Tests</h3>

                <div class="card-tools" style="float: right;">
                    <a class="btn btn-primary" href="{{ url('admin/addTest') }}">Add New</a>
                </div>
              </div>
                
              <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Test Name</th>
                                <th>Test Price</th>
                                <th>Class</th>
                                <th>Subject</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count=1; ?>
                            @foreach($ts as $t)
                                <tr>
                                    <td>{{ $t->tId }}</td>
                                    <td><a href="{{ url('admin/testSection/'. $t->tId )}}"> {{ $t->tName }} </a></td>

                                    <td>
                                        @if ($t->tPrice != null) 
                                            <a href="{{ url('admin/tests/payments/'. $t->tId )}}"> {{ $t->tPrice }} </a>
                                        @else
                                            Free
                                        @endif
                                    </td>

                                    <td>{{ $t->tClass }}</td>
                                    <td>{{ $t->tSubject }}</td>
                                    <td class="text-center">
                                        @if($t->tStatus == 0)
                                            <a href="{{ url('admin/tests/activate/'.$t->tId) }}" class="text-success">
                                                <i class="far fa-ban"></i>
                                            </a>
                                        @elseif($t->tStatus == 1)
                                            <a href="{{ url('admin/tests/deactivate/'.$t->tId) }}" class="text-danger">
                                                <i class="far fa-ban"></i>
                                            </a>
                                        @endif

                                        <a class="btn text-info btn-sm" href="{{ url('admin/updateTest/'.$t->tId) }}">
                                            <i class="far fa-edit"></i>
                                        </a>

                                        <a href="{{ url('admin/tests/remove/'.$t->tId) }}" class="text-danger" onclick="confirm('Are Your Sure want to remove this test?');">
                                            <i class="far fa-trash-alt"></i>
                                        </a>

                                        <a href="{{ url('admin/tests/users/'.$t->tId) }}" class="text-success">
                                            <i class="fad fa-users"></i>
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
                Footer
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
