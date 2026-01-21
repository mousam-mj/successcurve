
@extends('layout')
@section('title')
Question Reports
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
        
        <div class="col-md-9 col-12 dash-container">
            
            @if(Session::get('errors'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>{{ $errors }}!</strong> 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @endif
            @if($success ?? '')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>{{ $success ?? '' }}!</strong> 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
            @endif
            
            <div class="card">
              <div class="card-header">
                <h3 class="card-title" style="float: left;"> Question Reports</h3>

                <div class="card-tools" style="float: right;">
                    
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Question</th>
                                <th>Issue</th>
                                <th>Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $tc)
                                <tr>
                                    <td>{{ $tc->rpId }}</td>
                                    <td>{!! $tc->qwTitle !!}</td>
                                    <td >
                                        {{ $tc->rpContent }}
                                    </td>
                                    <td >
                                        {{ $tc->created_at }}
                                    </td>
                                    <td>
                                        <a class="btn-sm text-info" href="{{ url('faculty/editQuestion/'. $tc->qwId) }}">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a class="btn-sm text-danger" href="{{ url('faculty/deleteReport/'.$tc->rpId) }}"><i class="far fa-trash-alt"></i></a>
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
  
</script>
@endsection
