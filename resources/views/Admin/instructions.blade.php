
@extends('layout')
@section('title')
Test Instructions
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
                <h3 class="card-title" style="float: left;"> Test Instructions</h3>

                <div class="card-tools" style="float: right;">
                    <a class="btn btn-primary" href="{{ url('admin/addIns') }}">Add New</a>
                </div>
              </div>
                
                
              <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count=1; ?>
                            @foreach($ins as $in)
                                <tr>
                                    <td>{{ $in->inId }}</td>
                                    <td>{{ $in->inTitle }}</td>
    
                                    <td class="text-center">
                                        <input type="hidden" value="{{ $in->inId }}" id="stib<?php echo $count;?>">
                                        
                                        <a class="btn text-info ebtn" href="{{ url('admin/updateIns') }}?insid={{ $in->inId }}">
                                            <i class="far fa-edit"></i>
                                        </a>
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
        
        $('.ebtn').click(function(){
            var btnId = this.id;
            var insId = '#sti'+btnId;
            $.ajax({
                url: "admin/updateIns",
                type: "POST",
                data:{ 
                    _token: '{{csrf_token()}}',
                    insid: insId,
                },
                cache: false,
                dataType: 'json',
                
            });
        });
        
       
    });
    
</script>
@endsection
