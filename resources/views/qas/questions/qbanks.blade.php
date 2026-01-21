
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
                <h3 class="card-title" style="float: left;">{{ $titles }}</h3>

                <div class="card-tools" style="float: right;">
                    <a class="btn btn-primary text-white btn-sm" data-toggle="modal" data-target="#addModel">Add New</a>
                </div>
                <div class="modal fade" id="addModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Create Question Bank</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('qas/qbs/add') }}" method="POST"  class="form-group">
                                @csrf
                                <div class="form-group">
                                    <label for="title" class="log-label">Questionbank Title</label>
                                    <input type="text" name="title" id="title" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-sm">Create QuestionBank </button>
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
                          <h5 class="modal-title" id="updateModalLabel">Update Question Bank</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('qas/qbs/update') }}" method="POST"  class="form-group">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" name="uqbId" id="uqbId" >

                                    <label for="title" class="log-label">Questionbank Title</label>
                                    <input type="text" name="utitle" id="utitle" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-sm">Update QuestionBank </button>
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
                                <th>Question Bank</th>
                                <th>Total Questions</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($qbs as $qb)
                                <tr>
                                    <td>
                                        {{ $qb['qbId']}}
                                       
                                    </td>
                                    <td>
                                        <a href="{{ url('qas/sqbs/'.$qb['qbId']) }}" class="text-info">
                                            {!! $qb['qbName'] !!} </a>
                                    </td>
                                    <td>
                                      {{ $qb['tqnos'] }}
                                    </td>

                                    <td class="text-center">
                                        <a class="text-info btn-sm editBtn" href="javascript:void(0);"  data-id="{{ $qb['qbId'] }}" data-name="{{ $qb['qbName'] }}" >
                                            <i class="far fa-edit"></i>
                                        </a>
										
										@if ($status == 1)
											<a class="text-danger btn-sm" href="{{ url('qas/qbs/remove/'.$qb['qbId']) }}">
												<i class="far fa-trash-alt"></i>
											</a>
										@elseif($status == 0)
											
											<a href="{{ url('qas/qbs/restore/'.$qb['qbId']) }}" class="text-success btn-sm">
												<i class="far fa-trash-undo"></i>
											</a>

											<a class="text-danger btn-sm" onclick="confirm('Are you sure want to delete?');" href="{{ url('qas/qbs/delete/'.$qb['qbId']) }}">
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
		$("#uqbId").val($(this).data('id'));
		$("#utitle").val($(this).data('name'));

		$('#updateModel').modal('show');
	});
});

</script>

@endsection
