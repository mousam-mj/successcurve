
@extends('layout')
@section('title')
Create Subject Master
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
                <h3 class="card-title" style="float: left;"> Subject Topics</h3>

                <div class="card-tools" style="float: right;">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add New</button>
                </div>
              </div>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Subect Topic</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                        <form action="{{ url('admin/addST') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="text" name="name" placeholder="Topic Name" required class="form-control">
                                </div>
                                <div class="form-group">
                                    <select name="subject" class="form-control" id="subject" required>
                                        <option value="0">Select Subject</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Add   Topic</button>
                            </div>
                        </form>
                      
                    </div>
                  </div>
                </div>
<!--                Modal ends-->
                <!-- Modal -->
                <div class="modal fade" id="updateModel" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Update Topic </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                        <form action="{{ url('admin/updateST') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    
                                    <input type="hidden" name="uid" id="uid">
                                    
                                    <input type="text" id="uname" name="uname" placeholder="Topic Name" required class="form-control">
                                </div>
                                <div class="form-group">
                                    <select name="usubject" class="form-control" id="usubject" required>
                                        <option value="0">Select Subject</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Update Topic</button>
                            </div>
                        </form>
                      
                    </div>
                  </div>
                </div>
<!--                Modal ends-->
              <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Topic</th>
                                <th>Subject</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count=1; ?>
                            @foreach($tcs as $tc)
                                <tr>
                                    <td>{{ $tc->stId }}</td>
                                    <td>{{ $tc->stName }}</td>
                                    <td>
                                        {{ $tc->subjectName }}
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" value="{{ $tc->stId }}" id="stib<?php echo $count;?>">
                                        <input type="hidden" value="{{ $tc->stName }}" id="stnb<?php echo $count;?>">
                                        <input type="hidden" value="{{ $tc->subjectId }}" id="stsib<?php echo $count;?>">
                                        
                                        <button class="btn text-info" id="b<?php echo $count;?>" onclick="editTc(this.id);">
                                            <i class="far fa-edit"></i>
                                        </button>
                                    </td>
                                    <td><i class="far fa-trash-alt"></i></td>
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
                    $("#usubject").append(bodyData);
            }
        });
       
    });
    function editTc( bid ){
        var btnId = bid; 
        var tcid = '#sti'+btnId;
        var nid = '#stn'+btnId;
        var sid = '#stsi'+btnId; 
        
        $('#uid').val($(tcid).val());
        $('#uname').val($(nid).val());
        $("#usubject").val($(sid).val());
        
        $('#updateModel').modal('show');
    }
    
</script>
@endsection
