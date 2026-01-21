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
                    <img src= "{{ URL::asset(Session::get('userImage')) }}" alt="{{Session::get('userImage')}}" class="ds-img">
                </div>
                  <div class="s-cont">
                    <h3 class="ds-name">{{Session::get('user')}} </h3>
                      <p class="ds-p">{{Session::get('userEmail')}}</p>
                  </div>
              </div>
            @include('Student.sidebar')
        </div>
        
        <div class="col-md-9 col-12 dash-container">
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title" style="float: left;"> Course Payments</h3>
                </div>
               
              <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Course Name</th>
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
                                    <td>{{ $tc->courseTitle }}</td>
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
