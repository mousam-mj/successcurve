
@extends('layout')

@section('title')
Create Test Series
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
                <h3 class="dash-header-title">Add Test Series</h3>
            </div>
            {{-- <div class="dash-form-box"> --}}
                
                <form action="{{ url('faculty/addTc') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="ds-label"><i class="far fa-file-signature"></i> Test Series Name</label>
                            <input type="text" name="name" placeholder="Name" required class="form-control">
                        </div> 
                        
                        
                        <div class="form-group">
                            <label for="description" class="ds-label"><i class="far fa-file-signature"></i> Test Series Description</label>
                            <textarea name="description" id="summary-ckeditor"  class="form-control"></textarea>
                        </div> 
                        
                        <div class="form-group">
                            <label for="cls" class="ds-label"><i class="far fa-users-class"></i> Class</label>
                            <select name="cls" id="cls" class="form-control">
                                <option value="0">Select Class</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group pr-10">
                                        <label for="isPaid" class="ds-label"><i class="far fa-hand-holding-usd"></i> Is Paid</label>
                                        <select name="isPaid" id="isPaid" class="form-control">
                                            <option value="0">False</option>
                                            <option value="1">True</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group pl-10" id="costbox">
                                        <label for="cost" class="ds-label"><i class="far fa-rupee-sign"></i> Cost</label>
                                        <input type="number" step='0.01' placeholder='40.00' name="cost" id="cost" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group pr-10">
                                        <label for="startDate" class="ds-label"><i class="far fa-calendar-alt"></i> Start Date</label>
                                        <input type="datetime-local" class="form-control" id="startDate" name="startDate" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group pl-10">
                                        <label for="endDate" class="ds-label"><i class="far fa-calendar-alt"></i> End Date</label>
                                        <input type="datetime-local" class="form-control" id="endDate" name="endDate" required>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        
                        <div class="form-group">
                            <label for="image" class="ds-label"><i class="fal fa-images"></i> Thumbnail</label>
                            <input type="file" name="image" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="keywords" class="ds-label"><i class="far fa-file-signature"></i> Meta Keywords</label>
                            <textarea name="keywords" id="keywords" rows="3" class="form-control"></textarea>
                        </div> 
                        <div class="form-group">
                            <label for="metadescription" class="ds-label"><i class="far fa-file-signature"></i> Meta Description</label>
                            <textarea name="metadescription" id="metadescription" rows="3" class="form-control"></textarea>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add Test Series</button>
                    </div>
                </form>
            {{-- </div>         --}}
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
