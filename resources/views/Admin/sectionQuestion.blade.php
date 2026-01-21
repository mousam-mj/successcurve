
@extends('layout')
@section('title')
Section Question
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
                <h3 class="card-title" style="float: left;">Questions of {{ $tsecs->tsecName }}</h3>

                <div class="card-tools" style="float: right;">
                    <a class="btn btn-primary" href="{{ url('admin/addQuestionToSection/'.$tsecs->tsecId) }}">Add New</a>
                </div>
              </div>
                
              <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Questions</th>
                                <th>Answer</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count=1; ?>
                            @foreach($ques as $que)
                                <tr>
                                    <td>{{ $que->qwId }}</td>
                                    <td>{!! $que->qwTitle !!}</td>
                                    <td>{!! $que->qwCorrectAnswer !!}</td>
                                    <td>
                                        @if ($que->paragraphId != 0)
                                        <span class="typelabel bg-primary text-white">Paragraph</span>
                                        @else
                                            @if ($que->qwType == 'radio')
                                                <span class="typelabel bg-danger text-white">MCQ</span>
                                            @elseif ($que->qwType == 'checkbox')
                                            <span class="typelabel bg-warning text-white">MSQ</span>
                                            @elseif ($que->qwType == 'nat')
                                            <span class="typelabel bg-info text-white">NAT</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-danger btn-sm" href="{{ url('admin/removeSectionQuestion/'.$que->qwId.'/'.$tsecs->tsecId) }}">
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
    
</script>

@endsection
