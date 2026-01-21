
@extends('layout')

@section('title')
Edit Test Series | {{ $tcs->tcName }}
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
                <h3 class="dash-header-title">Edit Test Series | {{ $tcs->tcName }}</h3>
            </div>
            {{-- <div class="dash-form-box"> --}}
                
                <form action="{{ url('faculty/tests/updateTc') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="utcid" id="utcid"  readonly  class="form-control" value="{{ $tcs->tcId }}">
                           
                            <input type="text" name="uname" id="uname" placeholder="Name" required class="form-control" value="{{ $tcs->tcName }}">
                        </div>
                        <div class="form-group">
                            <label for="udescription" class="ds-label"><i class="far fa-file-signature"></i> Test Series Description</label>
                            <textarea name="udescription" id="summary-ckeditor" rows="3" class="form-control">
                                {!! $tcs->tcDescription !!}
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label for="ucls" class="ds-label"><i class="far fa-users-class"></i> Class</label>
                            <select name="ucls" id="ucls" class="form-control">
                                <option value="0">Select Class</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group pr-10">
                                        <label for="uisPaid" class="ds-label"><i class="far fa-hand-holding-usd"></i> Is Paid</label>
                                        <select name="uisPaid" id="uisPaid" class="form-control">
                                            <option value="0"
                                            @if ( $tcs->tcType == 0 )
                                                {{ 'selected' }}
                                            @endif
                                            >False</option>
                                            <option value="1"
                                            @if ( $tcs->tcType == 1 )
                                                {{ 'selected' }}
                                            @endif
                                            >True</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group pl-10" id="costbox">
                                        <label for="ucost" class="ds-label"><i class="far fa-rupee-sign"></i> Cost</label>
                                        <input type="number" step='0.01' placeholder='40.00' name="ucost" id="ucost" class="form-control" value="{{ $tcs->tcFees }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <input type="file" name="uimage" class="form-control">
                            Current Image: <small id="uimagehelp" class="form-text text-muted">{{ $tcs->tcImage }}</small>
                        </div>
                        <div class="form-group">
                            <label for="ukeywords" class="ds-label"><i class="far fa-file-signature"></i> Meta Keywords</label>
                            <textarea name="ukeywords" id="ukeywords" rows="3" class="form-control">{{ $tcs->tcKeywords }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="umetadescription" class="ds-label"><i class="far fa-file-signature"></i> Meta Description</label>
                            <textarea name="umetadescription" id="umetadescription" rows="3" class="form-control">{{ $tcs->tcMetaDesc }}</textarea>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Test Series</button>
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
        if($('#uisPaid').val() == 0){
            $('#ucost').val(0.00);
            $('#costbox').hide();
        }
        $('#uisPaid').change(function(){
            var data = $(this).val();
            
            if(data == 1){
                $('#costbox').show();
           }
            else if(data ==0){
                $('#ucost').val(0.00);
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
                var cl = '{{ $tcs->tcClass }}'
                $.each(resultData,function(index,row){
                    if(row.classId == cl){
                        bodyData+="<option value="+ row.classId +" selected>"+ row.className +"</option>";
                    }else{
                        bodyData+="<option value="+ row.classId +">"+ row.className +"</option>";
                    }
                })
                $("#cls").append(bodyData);
                $("#ucls").append(bodyData);
            }
        });
    });
        
        
    </script>
@endsection
