@extends('layout')
@section('title')
Course Payments
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
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title" style="float: left;"> Course Payments : {{ $course->courseTitle }}</h3>
                </div>
               
              <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Price</th>
                                <th>Purchased At</th>
                                <th>Expires At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count=1; ?>
                            @foreach($pcs as $tc)
                                <tr>
                                    <td>{{ $count }}</td>
                                    <td>{{ $tc->userName }}</td>
                                    <td>{{ $tc->userContact }}</td>
                                    <td>{{ $tc->amount }}</td>
                                    <td>{{ $tc->updated_at }}</td>
                                    <td>{{ $tc->expires_at }} </td>
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
