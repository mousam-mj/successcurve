
@extends('layout')

@section('title')
Update Test
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
                <h3 class="dash-header-title">Create Test</h3>
            </div>
            <div class="dash-form-box">
                <form action="{{URL('admin/updateTestContent')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="form-group">
                        <label for="name" class="ds-label"><i class="fas fa-clipboard"></i> Test Title</label>
                        <input type="text" class="form-control" name="name" value="{{$tests->tName}}" id="name" required>
                        
                        <input type="hidden" value="{{$tests->tId}}" name="tid">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group pr-10">
                                    <label for="subject" class="ds-label"><i class="fas fa-clipboard"></i> Subject</label>
                                    <select name="subject" id="subject" class="form-control">
                                        <option value="0">Select Subject</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group pl-10">
                                    <label for="cls" class="ds-label"><i class="fas fa-clipboard"></i> Class</label>
                                    <select name="cls" id="cls" class="form-control">
                                        <option value="0">Select Class</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group pr-10">
                                    <label for="instructions" class="ds-label"><i class="fas fa-clipboard"></i> Instruction</label>
                                    <select name="instructions" id="instructions" class="form-control">
                                        <option value="0">Select Instructions</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group pl-10">
                                    <label for="duration" class="ds-label"><i class="fas fa-clipboard"></i> Duration</label>
                                    <input type="number" min="1" max="500" name="duration" id="duration" class="form-control" placeholder="In Minutes" required value="{{$tests->duration}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group pr-10">
                                    <label for="isPaid" class="ds-label"><i class="fas fa-clipboard"></i> Is Paid</label>
                                    <select name="isPaid" id="isPaid" class="form-control">
                                        <option value="0" <?php if($tests->is_paid == 0){echo 'selected';} ?> >False</option>
                                        <option value="1" <?php if($tests->is_paid == 1){echo 'selected';} ?> >True</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group pl-10" id="costbox">
                                    <label for="cost" class="ds-label"><i class="fas fa-clipboard"></i> Cost</label>
                                    <input type="number" step='0.01' placeholder='40.00' name="cost" id="cost" class="form-control" value="{{$tests->tPrice}}">
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" id="validitybox">
                            <div class="form-group" >
                                <label for="validity" class="ds-label"><i class="fas fa-user-clock"></i> Validity</label>
                                <input type="number" placeholder='Validity in Months' name="validity" id="validity" class="form-control" value="{{ $tests->tValidity }}">
                            </div>
                        </div>
                        <div class="col-md-6 pl-10">
                            <div class="form-group">
                                <label for="publish" class="ds-label"><i class="fas fa-clipboard"></i> Publish Result</label>
                                <select name="publish" id="publish" class="form-control">
                                    <option value="0" <?php if($tests->publish_result_immediately == 0){echo 'selected';} ?>  >Leter</option>
                                    <option value="1" <?php if($tests->publish_result_immediately == 0){echo 'selected';} ?>  >Immediately</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group pr-10">
                                    <label for="startDate" class="ds-label"><i class="fas fa-clipboard"></i> Start Date</label>
                                    <input type="datetime-local" class="form-control" id="startDate" name="startDate" value="{{$tests->start_date}}">
                                </div>
                                <small id="emailHelp" class="form-text text-muted">Prev: {{$tests->start_date}}</small>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group pl-10">
                                    <label for="endDate" class="ds-label"><i class="fas fa-clipboard"></i> End Date</label>
                                    <input type="datetime-local" class="form-control" id="endDate" name="endDate" value="{{$tests->end_date}}">
                                    <small id="emailHelp" class="form-text text-muted">Prev: {{$tests->end_date}}</small>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="description" class="ds-label"><i class="fas fa-info-circle"></i> Desription</label>
                        <textarea class="form-control" id="summary-ckeditor" name="description" required>{{$tests->description}}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="image" class="ds-label"><i class="far fa-image"></i> Thumbnail</label>
                        <input type="file" class="form-control" name="image" id="image" >
                        <small id="image" class="form-text text-muted">{{$tests->tImage}}</small>
                        <input type="hidden" class="form-control" name="pimage" id="pimage" value="{{$tests->tImage}}">
                    </div>
                    
                    <div class="form-group">
                        <label for="metakey" class="ds-label">Meta Keyword</label>
                        <textarea name="metakey" id="metakey"  class="form-control">{{$tests->tMetaKey}}</textarea>
                    </div>                    
                    <div class="form-group">
                        <label for="metadesc" class="ds-label">Meta Description</label>
                        <textarea name="metadesc" id="metadesc" class="form-control">{{$tests->tMetaDesc}}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-custom3 form-control">Update Test</button>
                    </div>
                </form>
            </div>        
      <!--        Container End   -->  
        </div>
        
        
        
        
    </div>
    
</div>

<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
CKEDITOR.replace( 'summary-ckeditor' );  
    
</script>


@endsection

@section('javascript')
<script>
$(document).ready(function() {
        
        
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
                var sid = <?php echo $tests->tSubject; ?>;
                    if(sid == row.subjectId){
                        bodyData+="<option value="+ row.subjectId +" selected>"+ row.subjectName +"</option>";
                    }else{
                        bodyData+="<option value="+ row.subjectId +">"+ row.subjectName +"</option>";
                    }
                    

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
                var sid = <?php echo $tests->tClass; ?>;
                    if(sid == row.classId){
                        bodyData+="<option value="+ row.classId +" selected>"+ row.className +"</option>";
                    }else{
                       bodyData+="<option value="+ row.classId +">"+ row.className +"</option>";
                    }
                

            })
            $("#cls").append(bodyData);
        }
    });
     $.ajax({
        url: "{{ URL('admin/getInstructions')}}",
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
                var sid = <?php echo $tests->ipId; ?>;
                    if(sid == row.inId){
                        bodyData+="<option value="+ row.inId +" selected>"+ row.inTitle +"</option>";
                    }else{
                        bodyData+="<option value="+ row.inId +">"+ row.inTitle +"</option>";
                    }
            })
            $("#instructions").append(bodyData);
        }
    });
    
    var p = $('#isPaid').val();
    if(p == 1){
        $('#costbox').show();
   }
    else if(p ==0){
        $('#cost').val(0.00);
        $('#costbox').hide();
    }
    
    
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
    
    
});
</script>
@endsection
