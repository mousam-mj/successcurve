
@extends('layout')
@section('title')
Create Test Catogery
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
                    <form action="{{ url('faculty/ts/filter') }}" method="GET" class="form-inline">

                        <label class="sr-only" for="fclass">Class</label>
                        <select class="form-control mb-2 mr-sm-2" id="fclass" name="fcls">
                            <option value="0">---- Choose Class -----</option>
                        </select>
                        
                        {{-- <label class="sr-only" for="subject">Subject</label>
                        <select class="form-control mb-2 mr-sm-2" id="subject" name="subject">
                            <option value="0">---- Choose Subject -----</option>
                        </select> --}}
                      
                      
                        <button type="submit" class="btn btn-primary mb-2">Filter</button>
                      </form>
                </div>
              <div class="card-header">
                <h3 class="card-title" style="float: left;">Test Series</h3>

                <div class="card-tools" style="float: right;">
                    <a class="btn btn-primary btn-sm" href="{{ url('faculty/ts/add') }}" >Add New</a>
                </div>
              </div>
               

              <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count=1; ?>
                            @foreach($tcs as $tc)
                                <tr>
                                    <td>{{ $tc->tcId }}</td>
                                    <td><a href="{{ url('faculty/testSeriesTests/'.$tc->tcId) }}">{{ $tc->tcName }}</a></td>
                                    <td>{{ $tc->tcStatus }}</td>
                                    <td>{{ $tc->created_at }}</td>
                                    <td class="text-center">
                                        @if($tc->tcStatus == 0)
                                            <a href="{{ url('faculty/ts/activate/'.$tc->tcId) }}" class="text-success">
                                                <i class="far fa-ban"></i>
                                            </a>
                                        @elseif($tc->tcStatus == 1)
                                            <a href="{{ url('faculty/ts/deactivate/'.$tc->tcId) }}" class="text-danger">
                                                <i class="far fa-ban"></i>
                                            </a>
                                        @endif
                                        <a class="btn text-info" href="{{ url('faculty/ts/edit/'.$tc->tcId) }}">
                                            <i class="far fa-edit"></i>
                                        </a>

                                        <a href="{{ url('faculty/ts/users/'.$tc->tcId) }}" class="text-success">
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
    $('#costbox').hide();
    $('#isPaid').change(function(){
        var data = $(this).val();
        
        if(data == 1){
            $('#costbox').show();
       }
        else if(data ==0){
            $('#cost').val(0.00);
            $('#costbox').hide();
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
            console.log(dataResult);
            var resultData = dataResult.data;
            var bodyData = '';
            $.each(resultData,function(index,row){
                bodyData+="<option value="+ row.classId +">"+ row.className +"</option>";

            })
            $("#cls").append(bodyData);
            $("#ucls").append(bodyData);
            $("#fclass").append(bodyData);
        }
    });
});
    
    
</script>
@endsection


