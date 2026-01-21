
@extends('layout')
@section('title')
{{ $title }} 
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
                <h3 class="card-title" style="float: left;">{{ $title }}</h3>

                <div class="card-tools" style="float: right;">
                    <a class="btn btn-primary" href="{{ url('admin/users/newUser/') }}">Add New</a>
                </div>
              </div>
                
              <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count=1; ?>
                            @foreach($users as $que)
                                <tr>
                                    <td>{{ $que->id }}</td>
                                    <td>{{ $que->name }}</td>
                                    <td>{{ $que->contact }}</td>
                                    <td>{{ $que->email }}</td>
                                    <td>
                                        {{ $que->type }}
                                    </td>
                                    <td class="text-center">
                                    @if($que->userStatus == 1)
                                        <a class="text-danger" href="{{ url('admin/user/ban/'.$que->id) }}">
                                            <i class="far fa-ban"></i>
                                        </a>
                                    @elseif ($que->userStatus == 2)
                                        <a class="text-success" href="{{ url('admin/user/unban/'.$que->id) }}">
                                        <i class="far fa-ban"></i>
                                    </a>
                                    @endif
                                        
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
