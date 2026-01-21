
@extends('layout')
@section('title')
Test Series Tests
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
            @if($success ?? '')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>{{ $success ?? '' }}!</strong> 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
            @endif
            
            <div class="card">
              <div class="card-header">
                <h3 class="card-title" style="float: left;">{{ $tcs->tcName }}</h3>

                <div class="card-tools" style="float: right;">
                    <a class="btn btn-primary" href="{{URL('admin/addTestToSeries/'.$tcs->tcId)}}">Add New</a>
                </div>
              </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Test</th>
                                <th>Duration</th>
                                <th>Marks</th>
                                <th>Questions</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tests">
                            
                            @foreach($tsts as $tst)
                            <tr>
                                <td>{{ $tst->tId }}</td>
                                <td>{{ $tst->tName }}</td>
                                <td>{{ $tst->duration }}</td>
                                <td>{{ $tst->total_marks }}</td>
                                <td>{{ $tst->total_questions }}</td>
                                <td>
                                    <a class="btn btn-danger btn-sm" href="{{ url('admin/removeTestFromSeries/'.$tst->tstId.'/'.$tst->tId) }}">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
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
        }
    });
});
</script>
@endsection


