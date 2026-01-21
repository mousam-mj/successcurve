
@extends('layout')
@section('title')

{{ $titles }}
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
            @if(Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>{{ Session::get('success') }}!</strong> 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
            @endif
            
            <div class="card">
              <div class="card-header">
                <h3 class="card-title" style="float: left;">
                  {{ $titles }}: {{ $sqbs->qbName }}</h3>

                <div class="card-tools" style="float: right;">
                    <a class="btn btn-primary text-white btn-sm" data-toggle="modal" data-target="#addModel">Add New</a>
                </div>
                
                <div class="modal fade" id="addModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Create Question Topics</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('admin/qts/add') }}" method="POST"  class="form-group">
                                @csrf
                                <input type="hidden" name="qbid" value="{{ $sqbs->qbId }}">
                                <input type="hidden" name="pqbid" value="{{ $sqbs->parentQbId }}">

                                <div class="form-group">
                                    <label for="title" class="log-label">Question Topic Title</label>
                                    <input type="text" name="title" id="title" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-sm">Create Topic </button>
                                </div>
                            </form>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="modal fade" id="updateModel" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="updateModalLabel">Create Question Topics</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('admin/qts/update') }}" method="POST"  class="form-group">
                                @csrf
                                <input type="hidden" name="uqbid" value="{{ $sqbs->qbId }}">
                                <input type="hidden" name="upqbid" value="{{ $sqbs->parentQbId }}">
                                <input type="hidden" name="uqtid" id="uqtid">

                                <div class="form-group">
                                    <label for="title" class="log-label">Question Topic Title</label>
                                    <input type="text" name="utitle" id="utitle" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-sm">Update Topic </button>
                                </div>
                            </form>
                        </div>
                      </div>
                    </div>
                </div>


              </div>
                
              <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Question Topic</th>
                                <th>Total Questions</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($qts as $qb)
                                <tr>
                                    <td>
                                        {{ $qb['qtId']}}
                                       
                                    </td>
                                    <td>
                                        <a href="{{ url('admin/sqts/'.$qb['qtId']) }}" class="text-info">
                                            {!! $qb['qtName'] !!} </a>
                                    </td>
                                    <td>{{ $qb['tqnos'] }}</td>
                                    <td class="text-center">
                                        <a class="text-info btn-sm editBtn" href="javascript:void(0);" data-id="{{ $qb['qtId'] }}" data-name="{{ $qb['qtName'] }}">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        @if($status == 0)
                                          <a class="text-danger btn-sm" href="{{ url('admin/qts/remove/'.$qb['qtId']) }}">
                                              <i class="far fa-trash-alt"></i>
                                          </a>
                                        @elseif($status == 1)
                                          <a href="{{ url('admin/qts/restore/'.$qb['qtId']) }}" class="text-success btn-sm">
                                            <i class="far fa-trash-undo"></i>
                                          </a>
                    
                                          <a class="text-danger btn-sm" onclick="confirm('Are you sure want to delete?');" href="{{ url('admin/qts/delete/'.$qb['qtId']) }}">
                                            <i class="far fa-trash-alt"></i>
                                          </a>
                                        @endif()
                                        
                                    
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
                @if($status == 0) 
                  <a href="{{ url('admin/qts/trash/'.$sqbs->qbId) }}" class="text-danger"> <i class="fas fa-trash-alt"></i> Trash </a>
                @elseif ($status == 1)
                  <a href="{{ url('admin/qts/'.$sqbs->qbId) }}" class="text-primary"> <i class="far fa-arrow-circle-left"></i> Question Topics </a>
                @endif
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
    $(".editBtn").click(function(){
      $("#uqtid").val($(this).data('id'));
      $("#utitle").val($(this).data('name'));

      $('#updateModel').modal('show');
    });
});
</script>

@endsection
