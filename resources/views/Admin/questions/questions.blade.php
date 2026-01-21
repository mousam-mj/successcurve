
@extends('layout')
@section('title')
Questions
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
                <h3 class="card-title" style="float: left;">Questions : {{ $qls->qlName }}</h3>

                <div class="card-tools" style="float: right;">
                    <!-- Example split danger button -->
                    <!-- Example single danger button -->
                    <div class="btn-group">

                        <button type="button" class="btn btn-success  btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Excel
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ url('admin/qns/mcq/up/new/'.$qls->qlId) }}">Upload Excel</a>
                            <a class="dropdown-item" href="{{ url('admin/qns/mcq/format') }}" target="_blank">Download Format</a>
                        </div>
                    </div>
                    <div class="btn-group">

                        <button type="button" class="btn btn-danger  btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        MCQ
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ url('admin/qns/mcq/new/'.$qls->qlId) }}">Add MCQ</a>
                            
                            <a class="dropdown-item" href="{{ url('admin/qns/mcq/list/'.$qls->qlId) }}">List MCQ</a>
                        </div>
                    </div>

                    {{-- Multi Select --}}
                    <div class="btn-group">
                        <button type="button" class="btn btn-warning  btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        MSQ
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ url('admin/qns/msq/new/'.$qls->qlId) }}">Add MSQ</a>
                            <a class="dropdown-item" href="{{ url('admin/qns/msq/list/'.$qls->qlId) }}">List MSQ</a>
                        </div>
                    </div>
                    {{-- Multi Select --}}
                    <div class="btn-group">
                        <button type="button" class="btn btn-info  btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        NAT
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ url('admin/qns/nat/new/'.$qls->qlId) }}">Add NAT</a>
                            <a class="dropdown-item" href="{{ url('admin/qns/nat/list/'.$qls->qlId) }}">List NAT</a>
                        </div>


                    </div>
                    {{-- Multi Select --}}
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary  btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        PR
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ url('admin/qns/newPara/'.$qls->qlId) }}">Add Paragraph</a>
                            <a class="dropdown-item" href="{{ url('admin/qns/pr/new/'.$qls->qlId) }}">Add PRQ</a>
                            <a class="dropdown-item" href="{{ url('admin/para/list/'.$qls->qlId) }}">List Paragraph</a>
                            <a class="dropdown-item" href="{{ url('admin/qns/pr/list/'.$qls->qlId) }}">List PRQ</a>
                        </div>
                    </div>
                </div>
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

                                        @if ($que->paragraphId != 0)
                                        <a class="text-info btn-sm" href="{{ url('admin/qns/pr/edit/'. $que->qwId) }}">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        @else
                                            @if ($que->qwType == 'radio')
                                                <a class="text-info btn-sm" href="{{ url('admin/qns/mcq/edit/'. $que->qwId) }}">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                            @elseif ($que->qwType == 'checkbox')
                                            <a class="text-info btn-sm" href="{{ url('admin/qns/msq/edit/'. $que->qwId) }}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @elseif ($que->qwType == 'nat')
                                            <a class="text-info btn-sm" href="{{ url('admin/qns/nat/edit/'. $que->qwId) }}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endif
                                        @endif
                                        
                                        <a class="text-danger btn-sm" href="{{ url('admin/qns/remove/'.$que->qwId) }}">
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
                <a href="{{ url('admin/qns/trash/'.$qls->qlId) }}" class="text-danger"> <i class="fas fa-trash-alt"></i> Trash </a>
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
