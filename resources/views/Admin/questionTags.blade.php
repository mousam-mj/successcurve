
@extends('layout')
@section('title')
Question Tags
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
                <h3 class="card-title" style="float: left;"> Question Tags</h3>

                <div class="card-tools" style="float: right;">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add New</button>
                </div>
              </div>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Question Tag</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                        <form action="{{ url('admin/addQuestionTag') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="text" name="name" placeholder="Tag Name" required class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Add Question Tag</button>
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
                        <h5 class="modal-title" id="updateModalLabel">Update Question Tag </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                        <form action="{{ url('admin/updateQuestionTag') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    
                                    <input type="hidden" name="uid" id="uid">
                                    
                                    <input type="text" id="uname" name="uname" placeholder="Tag Name" required class="form-control">
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Update Question Tag</button>
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
                                <th>Tag</th>
<!--                                <th>No Of Questions</th>-->
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count=1; ?>
                            @foreach($tags as $que)
                                <tr>
                                    <td>{{ $que->qtId }}</td>
                                    <td>{!! $que->qtName !!}</td>
<!--                                    <td>{!! $que->qtTotalQuestions !!}</td>-->
                                    
                                    <td class="text-center">
                                        <input type="hidden" value="{{ $que->qtId }}" id="stib<?php echo $count;?>">
                                        <input type="hidden" value="{{ $que->qtName }}" id="stnb<?php echo $count;?>">
                                        
                                        <button class="btn text-info" id="b<?php echo $count;?>" onclick="editTc(this.id);">
                                            <i class="far fa-edit"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-danger" href="{{ url('admin/deleteQuestionTag/'.$que->qtId) }}">
                                            <i class="far fa-trash-alt"></i>
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
        var tcid = '#sti'+btnId;
        var nid = '#stn'+btnId;
        
        $('#uid').val($(tcid).val());
        $('#uname').val($(nid).val());
        
        $('#updateModel').modal('show');
    }
    
</script>
@endsection
