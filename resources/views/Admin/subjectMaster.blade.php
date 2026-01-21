
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
                <h3 class="card-title" style="float: left;"> Subjects</h3>

                <div class="card-tools" style="float: right;">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add New</button>
                </div>
              </div>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Subect Master</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                        <form action="{{ url('admin/addSM') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="text" name="name" placeholder="Name" required class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="file" name="image" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Add Subject</button>
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
                        <h5 class="modal-title" id="updateModalLabel">Update Subject </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                        <form action="{{ url('admin/updateSM') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="hidden" name="utcid" id="utcid"  readonly  class="form-control">
                                    <input type="hidden" name="uimageprev" id="uimageprev" placeholder="Id" readonly class="form-control">
                                    <input type="text" name="uname" id="uname" placeholder="Name" required class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="file" name="uimage" class="form-control">
                                    Current Image: <small id="uimagehelp" class="form-text text-muted"></small>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Update Subject</button>
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
                                <th>Name</th>
                                <th>Image</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count=1; ?>
                            @foreach($tcs as $tc)
                                <tr>
                                    <td>{{ $tc->subjectId }}</td>
                                    <td>{{ $tc->subjectName }}</td>
                                    <td>
                                        <img src="{{ URL::asset($tc->thumbnail) }}" alt="" height="75" width="100">
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" value="{{ $tc->subjectId }}" id="tcidb<?php echo $count;?>">
                                        <input type="hidden" value="{{ $tc->subjectName }}" id="tcnb<?php echo $count;?>">
                                        <input type="hidden" value="{{ $tc->thumbnail }}" id="tcib<?php echo $count;?>">
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
    });
    function editTc( bid ){
        var btnId = bid; 
        var tcid = '#tcid'+btnId;
        var nid = '#tcn'+btnId;
        var sid = '#tcst'+btnId; 
        var iid = '#tci'+btnId;
        $('#utcid').val($(tcid).val());
        $('#uname').val($(nid).val());
        $("#ustatus").val($(sid).val());
        $("#uimagehelp").html($(iid).val());
        $("#uimageprev").val($(iid).val());
        
        $('#updateModel').modal('show');
    }
    
</script>
@endsection
