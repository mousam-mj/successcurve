
@extends('layout')
@section('title')
Questions Trash
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
                <h3 class="card-title" style="float: left;">Questions Trash : {{ $qls->qlName }}</h3>

              </div>

              <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Questions</th>
                                <th>Type</th>
                                <th>Answer</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count=1; ?>
                            @foreach($qns as $que)
                                <tr>
                                    <td>{{ $que->qwId }}</td>
                                    <td>{!! $que->qwTitle !!}</td>
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
                                    <td>{!! $que->qwCorrectAnswer !!}</td>
                                    <td class="text-center">
                                        
                                        <a href="{{ url('admin/qns/preview/'.$que->qwId) }}" target="_blank" class="text-success btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a class="text-success btn-sm" href="{{ url('admin/qns/restore/'.$que->qwId) }}">
                                            <i class="fas fa-trash-undo-alt"></i>
                                        </a>
                                        
                                        <a class="text-danger btn-sm" href="{{ url('admin/qns/delete/'.$que->qwId) }}" onclick="return confirm('Are you sure want to delete?')">
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
                <a href="{{ url('admin/qns/'.$qls->qlId) }}" class="text-primary"> <i class="far fa-arrow-circle-left"></i> Questions </a>
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
