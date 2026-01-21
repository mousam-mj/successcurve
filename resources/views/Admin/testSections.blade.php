
@extends('layout')
@section('title')
Test Sections
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
                <h3 class="card-title" style="float: left;">Test Sections</h3>

                <div class="card-tools" style="float: right;">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add New</button>
                </div>
              </div>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Test Sections</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                        <form action="{{ url('admin/addTestSection') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="hidden" value=" {{ $tids }} " name="test" id="test">

                                    <input type="text" name="name" placeholder="Section Name" required class="form-control">
                                    <input type="text" name="marks" placeholder="Marks" required class="form-control">
                                    <input type="text" name="negmarks" placeholder="Negative Marks" required class="form-control">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-block">Add Section</button>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
<!--                Modal ends-->
                <!-- Modal -->
                <div class="modal fade" id="updateModel" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Update Test Section</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                        <form action="{{ url('admin/updateTestSection') }}" method="post">
                            @csrf
                            <div class="modal-body">

                                <div class="form-group">

                                    <input type="hidden" name="tsId" id="tsId"  readonly  class="form-control">

                                    <input type="text" name="uname" id="uname" placeholder="Name" required class="form-control">
                                     <input type="text" name="umarks" placeholder="Marks" required class="form-control">
                                    <input type="text" name="unegmarks" placeholder="Negative Marks" required class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-block">Update Section</button>
                            </div>
                        </form>

                    </div>
                  </div>
                </div>
<!--                Modal ends-->
              <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Test Section</th>
                                <th>Marks</th>
                                <th>Neg Marks</th>

                                <th>Action</th>
                            </tr>  
                        </thead>
                        <tbody>
                            <?php $count=1; ?>
                            @foreach($tcs as $tc)
                                <tr>
                                    <td>{{ $tc->tsecId }}</td>
                                    <td>
                                        <a class="text-info" href="{{ url('admin/sectionQuestion/'.$tc->tsecId) }}">
                                            {{ $tc->tsecName }}
                                        </a>
                                    </td>
                                    <td>{{ $tc->tsMarks }}</td>
                                    <td>{{ $tc->tsNegMarks }}</td>

                                    <td class="text-center">
                                        <input type="hidden" value="{{ $tc->tsecId }}" id="tsecidb<?php echo $count;?>">

                                        <input type="hidden" value="{{ $tc->tsecName }}" id="tsecnb<?php echo $count;?>">
                                        <input type="hidden" value="{{ $tc->tsMarks }}" id="tsecmb<?php echo $count;?>">
                                        <input type="hidden" value="{{ $tc->tsNegMarks }}" id="tsecnmb<?php echo $count;?>">


                                        <button class="btn text-info" id="b<?php echo $count;?>" onclick="editTc(this.id);">
                                            <i class="far fa-edit"></i>
                                        </button>
                                        <i class="far fa-trash-alt"></i></td>
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
    function editTc( bid ){
        var btnId = bid;
        var tcid = '#tsecid'+btnId;
        var nid = '#tsecn'+btnId;
        var mid = '#tsecm'+btnId;
        var nmid = '#tsecnm'+btnId;


        $('#tsId').val($(tcid).val());
        $('#uname').val($(nid).val());
        $('#umarks').val($(mid).val());
        $('#unegmarks').val($(nmid).val());


        $('#updateModel').modal('show');
    }

</script>
@endsection


