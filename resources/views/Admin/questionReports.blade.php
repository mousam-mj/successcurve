
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
              
              <div class="card-header">
                <form action="{{ url('admin/questionReports') }}" method="GET" class="form-inline">
                    <label class="sr-only" for="class">Class</label>
                    <select class="form-control mb-2 mr-sm-2" id="class" name="class">
                        <option value="0">All Classes</option>
                        @foreach($classes as $cls)
                            <option value="{{ $cls->classId }}" {{ (isset($filterClass) && $filterClass == $cls->classId) ? 'selected' : '' }}>
                                {{ $cls->className }}
                            </option>
                        @endforeach
                    </select>
                    
                    <label class="sr-only" for="subject">Subject</label>
                    <select class="form-control mb-2 mr-sm-2" id="subject" name="subject">
                        <option value="0">All Subjects</option>
                        @foreach($subjects as $sub)
                            <option value="{{ $sub->subjectId }}" {{ (isset($filterSubject) && $filterSubject == $sub->subjectId) ? 'selected' : '' }}>
                                {{ $sub->subjectName }}
                            </option>
                        @endforeach
                    </select>
                  
                    <button type="submit" class="btn btn-primary mb-2">Filter</button>
                    <a href="{{ url('admin/questionReports') }}" class="btn btn-secondary mb-2 ml-2">Reset</a>
                </form>
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
                                        <a class="btn-sm text-info" href="{{ url('admin/editQuestion/'. $tc->qwId) }}">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a class="btn-sm text-danger" href="{{ url('admin/deleteReport/'.$tc->rpId) }}"><i class="far fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>   
                    </table>
                </div>
                <!-- /.table-responsive -->
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        Showing {{ $reports->firstItem() ?? 0 }} to {{ $reports->lastItem() ?? 0 }} of {{ $reports->total() }} entries
                    </div>
                    <div>
                        {{ $reports->appends(request()->query())->links() }}
                    </div>
                </div>

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
            responsive: true,
            paging: false, // Disable DataTables pagination since we're using Laravel pagination
            searching: false, // Disable DataTables search since we have filters
            info: false
    });
    
    // Load classes and subjects via AJAX if needed
    // Classes and subjects are already loaded in the view
});
</script>
@endsection
