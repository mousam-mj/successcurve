@extends('layout')
@section('title')
    Edit Coupons
@endsection
@section('content')
    <div class="main-box">
        <div class="row">
            <div class="col-md-3 col-12 s-menu">

                <div class="s-dash">
                    <div class="d-img">
                        <img src="{{ URL::asset(Session::get('auserImage')) }}" alt="{{ Session::get('auserImage') }}"
                            class="ds-img">
                    </div>
                    <div class="s-cont">
                        <h3 class="ds-name">{{ Session::get('auser') }} </h3>
                        <p class="ds-p">{{ Session::get('auserEmail') }}</p>
                    </div>
                </div>
                @include('Admin.adminSidebar')
            </div>

            <div class="col-md-9 col-12 dash-container">

                @if (Session::get('errors'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ $errors }}!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ Session::get('success') }}!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="float: left;">Edit  Coupon</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ url('admin/coupons/update') }}" method="post">
                            @csrf

                            <input type="hidden" name="couponId" value="{{$coupon->cpId}}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="ds-label">Coupon Name</label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Coupon Name" required value="{{$coupon->cpName}}">
                                    </div>
                                </div>
                                <div class="col-md-6 pl-10">
                                    <label for="code" class="ds-label">Coupon Code</label>
                                    <input type="text" class="form-control" name="code" id="code" placeholder="Coupon Code" required value="{{$coupon->cpCode}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="discount" class="ds-label">Coupon Discount</label>
                                        <input type="number" class="form-control" name="discount" id="discount" placeholder="Coupon Discount" min="0" max="100" required value="{{$coupon->cpDiscount}}">
                                    </div>
                                </div>
                                <div class="col-md-6 pl-10">
                                    <label for="limit" class="ds-label">Coupon Limit</label>
                                    <input type="number" class="form-control" name="limit" id="limit" placeholder="Coupon Limit" required value="{{$coupon->cpLimit}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cfor" class="ds-label">Coupon For</label>
                                        <select  name="cfor" id="cfor" class="form-control">
                                            <option value="1" <?php if ($coupon->cpFor == 1) {echo('selected');} ?>>All</option>
                                            <option value="2" <?php if ($coupon->cpFor == 2) {echo('selected');} ?>>Course</option>
                                            <option value="3" <?php if ($coupon->cpFor == 3) {echo('selected');} ?>>Test</option>
                                            <option value="4" <?php if ($coupon->cpFor == 4) {echo('selected');} ?>>Test Series</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 pl-10">
                                    <label for="expire" class="ds-label">Coupon Expiry</label>
                                    <input type="datetime-local" class="form-control" id="expire" name="expire">
                                    <small id="expireHelp" class="form-text text-muted">Prev Date: {{ $coupon->expires_at }}</small>
  
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success">Add Coupon</button>
                            </div>
                        </form>
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
@endsection
