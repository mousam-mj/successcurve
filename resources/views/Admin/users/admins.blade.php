
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
                    <button type="button" class="btn btn-success btn-sm" id="exportBtn" style="margin-right: 10px;">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                    <a class="btn btn-primary" href="{{ url('admin/users/newUser/') }}">Add New</a>
                </div>
              </div>
              
              <div class="card-header">
                <form action="{{ url('admin/users/filter') }}" method="POST" class="form-inline" id="filterForm">
                    @csrf
                    <label class="sr-only" for="status">Status</label>
                    <select class="form-control mb-2 mr-sm-2" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="active" {{ (isset($filterStatus) && $filterStatus == 'active') ? 'selected' : '' }}>Active</option>
                        <option value="banned" {{ (isset($filterStatus) && $filterStatus == 'banned') ? 'selected' : '' }}>Banned</option>
                    </select>
                    
                    <label class="sr-only" for="search">Search</label>
                    <input type="text" class="form-control mb-2 mr-sm-2" id="search" name="search" placeholder="Search by name, email, phone..." value="{{ $filterSearch ?? '' }}">
                  
                    <button type="submit" class="btn btn-primary mb-2">Filter</button>
                    <a href="{{ url('admin/users/users') }}" class="btn btn-secondary mb-2 ml-2">Reset</a>
                </form>
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
                                        @if(isset($que->userStatus) && $que->userStatus == 2)
                                            <a class="text-success btn-sm" href="{{ url('admin/user/unban/'.$que->id) }}" title="Unban User">
                                                <i class="fas fa-check-circle"></i>
                                            </a>
                                        @else
                                            <a class="text-danger btn-sm" href="{{ url('admin/user/ban/'.$que->id) }}" title="Ban User">
                                                <i class="fas fa-ban"></i>
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
    
    // Export button click handler
    $('#exportBtn').click(function() {
        var status = $('#status').val();
        var search = $('#search').val();
        
        var url = "{{ url('admin/users/export') }}?";
        if (status) {
            url += 'status=' + encodeURIComponent(status) + '&';
        }
        if (search) {
            url += 'search=' + encodeURIComponent(search) + '&';
        }
        
        // Remove trailing & if exists
        url = url.replace(/[&]$/, '');
        
        window.location.href = url;
    });

});
    
</script>

@endsection
