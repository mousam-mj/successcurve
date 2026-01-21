
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
                <img src= "{{ URL::asset(Session::get('qaImage')) }}" alt="{{Session::get('qaImage')}}" class="ds-img">
            </div>
              <div class="s-cont">
                <h3 class="ds-name">{{Session::get('qaUser')}} </h3>
                  <p class="ds-p">{{Session::get('qaEmail')}}</p>
              </div>
          </div>
        @include('qas.sidebar')
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
                <h3 class="card-title" style="float: left;">{{ $titles }}: {{ $qts->qtName }}</h3>

                <div class="card-tools" style="float: right;">
                    <a class="btn btn-primary text-white" data-toggle="modal" data-target="#addModel">Add New</a>
                </div>
                <div class="modal fade" id="addModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Create Question Sub Topics</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('qas/sqts/add') }}" method="POST"  class="form-group">
                                @csrf
                                <input type="hidden" name="qbid" value="{{ $qts->qbId }}">
                                <input type="hidden" name="pqbid" value="{{ $qts->parentQbId }}">
                                <input type="hidden" name="qtid" value="{{ $qts->qtId }}">
                                

                                <div class="form-group">
                                    <label for="title" class="log-label">Question Topic Title</label>
                                    <input type="text" name="title" id="title" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-sm">Create Sub Topic </button>
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
                          <h5 class="modal-title" id="updateModalLabel">Create Question Sub Topics</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('qas/sqts/update') }}" method="POST"  class="form-group">
                                @csrf
                                <input type="hidden" name="usqtId" id="usqtId" >
                                

                                <div class="form-group">
                                    <label for="title" class="log-label">Question Topic Title</label>
                                    <input type="text" name="utitle" id="utitle" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-sm">Update Sub Topic </button>
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
                                <th>Question Sub Topic</th>
                                <th>Total Questions</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sqts as $qb)
                                <tr>
                                    <td>
                                        {{ $qb['qtId'] }}
                                       
                                    </td>
                                    <td>
                                        <a href="{{ url('qas/qls/'.$qb['qtId']) }}" class="text-info">
                                            {!! $qb['qtName'] !!} </a>
                                    </td>
                                    <td>{{ $qb['tqnos'] }}</td>
                                    <td class="text-center">
                                        <a class="text-info btn-sm editBtn" href="javascript:void(0);" data-id="{{ $qb['qtId'] }}" data-name="{{ $qb['qtName'] }}">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        @if( $status == 1)
                                          <a href="{{ url('qas/sqts/restore/'.$qb['qtId']) }}" class="text-success btn-sm">
                                            <i class="far fa-trash-undo"></i>
                                          </a>
                    
                                          <a class="text-danger btn-sm" onclick="confirm('Are you sure want to delete?');" href="{{ url('qas/sqts/delete/'.$qb['qtId']) }}">
                                            <i class="far fa-trash-alt"></i>
                                          </a>
                                        @elseif($status == 0 )
                                          <a class="text-danger btn-sm" href="{{ url('qas/sqts/remove/'.$qb['qtId']) }}">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                        @endif



                                        
                                    
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
                  <a href="{{ url('qas/sqts/trash/'.$qts->qtId) }}" class="text-danger"> <i class="fas fa-trash-alt"></i> Trash </a>
                @elseif ($status == 1)
                  <a href="{{ url('qas/sqts/'.$qts->qtId) }}" class="text-primary"> <i class="far fa-arrow-circle-left"></i> Sub Topics </a>
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
      $("#usqtId").val($(this).data('id'));
      $("#utitle").val($(this).data('name'));

      $('#updateModel').modal('show');
    });

});
</script>

@endsection
