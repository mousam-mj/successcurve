
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
                <form action="{{URL('admin/addTest')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="form-group">
                        <label for="name" class="ds-label"><i class="fas fa-clipboard"></i> Test Title</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="name" class="ds-label"><i class="fas fa-clipboard"></i> Test URI</label>
                        <input type="text" class="form-control" name="uri" id="uri" required>
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
                                    <input type="number" min="1" max="500" name="duration" id="duration" class="form-control" placeholder="In Minutes" required>
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
                                        <option value="0">False</option>
                                        <option value="1">True</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" id="costbox">
                                <div class="form-group pl-10" >
                                    <label for="cost" class="ds-label"><i class="fas fa-usd-square"></i> Cost</label>
                                    <input type="number" placeholder='40' name="cost" id="cost" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" id="validitybox">
                            <div class="form-group" >
                                <label for="validity" class="ds-label"><i class="fas fa-user-clock"></i> Validity</label>
                                <input type="number" placeholder='Validity in Months' name="validity" id="validity" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 pl-10">
                            <div class="form-group">
                                <label for="publish" class="ds-label"><i class="fas fa-clipboard"></i> Publish Result</label>
                                <select name="publish" id="publish" class="form-control">
                                    <option value="0">Leter</option>
                                    <option value="1">Immediately</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group pr-10">
                                    <label for="startDate" class="ds-label"><i class="fas fa-calendar-check"></i> Start Date</label>
                                    <input type="datetime-local" class="form-control" id="startDate" name="startDate" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group pl-10">
                                    <label for="endDate" class="ds-label"><i class="fas fa-calendar-exclamation"></i> End Date</label>
                                    <input type="datetime-local" class="form-control" id="endDate" name="endDate" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="description" class="ds-label"><i class="fas fa-info-circle"></i> Desription</label>
                        <textarea class="form-control" id="summary-ckeditor" name="description" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="image" class="ds-label"><i class="far fa-image"></i> Thumbnail</label>
                        <input type="file" class="form-control" name="image" id="image" >
                    </div>
                    
                    <div class="form-group">
                        <label for="metakey" class="ds-label">Meta Keyword</label>
                        <textarea name="metakey" id="metakey"  class="form-control"></textarea>
                    </div>                    
                    <div class="form-group">
                        <label for="metadesc" class="ds-label">Meta Description</label>
                        <textarea name="metadesc" id="metadesc" class="form-control"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-custom3 form-control">Create Test</button>
                    </div>
                </form>
            </div>        
      <!--        Container End   -->  
        </div>
        
        
        
        
    </div>
    
</div>

<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('ckfinder/ckfinder.js') }}"></script>
<script>
   var editor = CKEDITOR.replace( 'summary-ckeditor' );
CKFinder.setupCKEditor( editor ); 
    
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
                bodyData+="<option value="+ row.inId +">"+ row.inTitle +"</option>";

            })
            $("#instructions").append(bodyData);
        }
    });
    
    $('#costbox').hide();
    $('#isPaid').change(function(){
        var data = $(this).val();
        
        if(data == 1){
            $('#costbox').show();
            $('#validitybox').show();
       }
        else if(data ==0){
            $('#cost').val();
            $('#validity').val();
            $('#costbox').hide();
            $('#validitybox').hide();
        }
    });
    
    $('#negbox').hide();

    $('#isNeg').change(function(){
        var data = $(this).val();
        
        if(data == 1){
            $('#negbox').show();
       }
        else if(data ==0){
            $('#negMarks').val(0.00);
            $('#negbox').hide();
        }
    });
    $("#name").on("keyup", function(){
        $("#uri").val(generateSlug($(this).val()));
    });
});

function generateSlug(text){
    return text.toLowerCase().replace(/ /g,'-').replace(/[-]+/g, '-').replace(/[^\w-]+/g,'');
}
</script>
@endsection
