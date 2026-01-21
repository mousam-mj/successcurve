
@extends('layout')
@section('title', 'Sliders ')

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
                <h3 class="card-title" style="float: left;">Sliders</h3>

                <div class="card-tools" style="float: right;">
                    <a class="btn btn-primary btn-sm" href="{{ url('admin/sliders/new/') }}">Add New</a>
                </div>
              </div>

              <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Link</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sliders as $s)
                                <tr>
                                    <td>{{ $s->id }}</td>
                                    <td>{{ $s->name }}</td>
                                    <td>
                                        <a href="{{ $s->url }}" class="text-primary">Url</a>
                                    </td>
                                    <td>
                                        <img src="{{ asset($s->image) }}" alt="" width="120">
                                    </td>
                                    <td>
                                        @if($s->status == 0)
                                        <span class="badge badge-danger">Inactive</span>
                                        @elseif($s->status == 1)
                                        <span class="badge badge-success">Active</span>
                                        @endif

                                    </td>
                                    <td class="text-center">
                                        @if($s->status == 0)
                                            <a href="{{ url('admin/sliders/activate/'.$s->id) }}" class="text-success">
                                                <i class="fas fa-ban"></i>
                                            </a>
                                        @elseif($s->status == 1)
                                            <a href="{{ url('admin/sliders/deactivate/'.$s->id) }}" class="text-danger">
                                                <i class="fas fa-ban"></i>
                                            </a>
                                        @endif
                                        <a href="{{ url('admin/sliders/edit/'.$s->id) }}" class="text-primary p-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ url('admin/sliders/remove/'.$s->id) }}" class="text-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
              </div>
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
