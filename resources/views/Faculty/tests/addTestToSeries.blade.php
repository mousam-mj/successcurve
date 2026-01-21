
@extends('layout')
@section('title')
Add Question TO Section
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
                <h3 class="card-title" style="float: left;">Add Tests to {{ $tcs->tcName }} </h3>
                  <input type="hidden" value="{{$tcs->tcId}}" id="tsId">
<!--                  <input type="hidden" value="{{$tcs->tcClass}}" id="testid">-->
              </div>
                
              <div class="card-body">
                  <h3 class="card-title">Select Tests From</h3>
                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="ds-label" for="subject">Subject</label>
                                <select id="subject" name="subject" class="form-control">
                                    <option vlaue="0">Select Subject</option>
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cls" class="ds-label"><i class="far fa-users-class"></i> Class</label>
                                    <select name="cls" id="cls" class="form-control">
                                        <option value="0">Select Class</option>
                                    </select>
                            </div>
                        </div>
                    </div>
                  </div>
                  
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="mytable">
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
                            
                             
                        </tbody>   
                    </table>
                </div>
                <!-- /.table-responsive -->

              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                
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
    $('#mytable').DataTable({
            responsive: true
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
//            console.log(dataResult);
            var resultData = dataResult.data;
            var bodyData = '';
            $.each(resultData,function(index,row){
                    bodyData+="<option value="+ row.subjectId +">"+ row.subjectName +"</option>";

                })
                $("#subject").append(bodyData);
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
            $("#cls").html(bodyData);
        }
    });
    $('#subject').change(function(){
        var subId = $(this).val();
        var tsId = $('#tsId').val();
        var clsId = $('#cls').val();
         changeTests(tsId, clsId, subId);
    });
    $('#cls').change(function(){
        var clsId = $(this).val();
        var tsId = $('#tsId').val();
        var subId = $('#subject').val();
         changeTests(tsId, clsId, subId);
    });
    
    

}); 
function changeTests(tsId, clsId, subId){
//            alert("topic"+topic+"  section "+tsec);
     $('#mytable').DataTable().clear().draw();
     
    
    
    
    
    $.ajax({
        url: "{{ URL('faculty/getTestsLists')}}",
        type: "POST",
        data:{ 
            _token:'{{ csrf_token() }}',
            tcId: tsId,
            classId: clsId,
            subjectId: subId,
        },
        cache: false,
        dataType: 'json',
        success: function(dataResult){
            console.log(dataResult);
           $('#mytable').DataTable().clear().draw();
            var resultData = dataResult.data;            
            $.each(resultData,function(index,rows){ 
                $('#mytable').DataTable().row.add([rows.tId, rows.tName,rows.duration, rows.total_marks, rows.total_questions, '<button class="btn btn-primary addBtn" onclick="addTestToSeries('+rows.tId+')">Add</button>']).draw();
            })
        }
    });
}
    function addTestToSeries(tid){
        var tsId = $('#tsId').val();
        var subId = $('#subject').val();
        var clsId = $('#cls').val();
        $('.addBtn').attr("disabled", true);
        $.ajax({
            url: "{{ URL('faculty/addTestList')}}",
            type: "POST",
            data:{ 
                _token:'{{ csrf_token() }}',
                tId: tid,
                tsId: tsId,
                subId: subId,
                clsId: clsId,
            },
            cache: false,
            dataType: 'json',
            success: function(dataResult){
//            console.log(dataResult);
           $('#mytable').DataTable().clear().draw();
            var resultData = dataResult.data;
            var bodyData = '';
            var bodyData2 = '';
            
            $.each(resultData,function(index,rows){
                $('#mytable').DataTable().row.add([rows.tId, rows.tName,rows.duration, rows.total_marks, rows.total_questions, '<button class="btn btn-primary addBtn" onclick="addTestToSeries('+rows.tId+')">Add</button>']).draw();
            })
        }
    });
    }
</script>

@endsection
