@extends('layout')
@section('title')
Test Reports
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
                    <h3 class="card-title" style="float: left;"> Test Reports</h3>

                    <div class="card-tools" style="float: right;">
                    
                    </div>
                </div>
               
              <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Test Name</th>
                                <th>Attemp Date</th>
                                <th>Mark Scored/Total</th>
                                <th>Percentage</th>
                                <th>Attempts</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count=1; ?>
                            @foreach($trs as $tc)
                                <tr>
                                    <td>{{ $count }}</td>
                                    <td>{{ $tc->tName }}</td>
                                    <td>{{ $tc->updated_at }}</td>
                                    <td>{{ $tc->final_marks }} / {{ $tc->total_marks }} </td>
                                    <td>@if($tc->total_marks != 0)
                                        {{ number_format((float)(($tc->final_marks *100)/$tc->total_marks), 2, '.', '') }}
                                        @endif
                                    </td>
                                    <td>{{ $tc->attempts }}</td>
                                    <td class="text-center">
                                        <a class="btn-sm text-info" href="{{ url('result/testReport/'.$tc->resultId) }}" title="Test Result"><i class="far fa-eye"></i></a>

                                        <a class="btn-sm text-info" href="{{ url('student/testAnswers/'.$tc->resultId) }}" title="Test Detailed Answer"><i class="fas fa-poll-h"></i></a>
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
