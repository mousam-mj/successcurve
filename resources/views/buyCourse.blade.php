@extends('layout')

@section('title')
Purchase Course: {{ $courses->courseTitle }}
@endsection
@section('content')

<div class="purcboxmain">
    <div class="purcbox">
        <h2 class="purch1">Course Details</h2>
        <table class="table table-bordered mt-3">
            <thead>
              <tr>
                <th scope="col">Key</th>
                <th scope="col">Details</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Course Name</td>
                <td>{{ $courses->courseTitle }}</td>
              </tr>
              <tr>
                <td>Course Instructor</td>
                <td>{{ $courses->userName }}</td>
              </tr>
              <tr>
                <td>Course Price</td>
                <td>RS {{ $datas['amount'] }}</td>
              </tr>
              <tr>
                <td>Course Validity</td>
                <td>{{ $courses->courseValidity }} Months </td>
              </tr>
              <tr>
                <td colspan="2" class="text-center">
                    <form action="{{ url('payCourse') }}" method="POST" class="text-center mx-auto ">
                        @csrf
                        <script
                            src="https://checkout.razorpay.com/v1/checkout.js"
                            data-key="{{ $datas['key'] }}"
                            data-amount="{{ $datas['amount'] }}"
                            data-currency="INR"
                            data-order_id="{{ $datas['orderId'] }}"
                            data-buttontext="Pay with Razorpay"
                            data-name="Successcurve.In"
                            data-description="{{ $datas['name'] }}"
                            data-theme.color="#024f9d"
                        ></script>
                      <input type="hidden"  custom="Hidden Element" name="hidden">
                    </form>
                
                </td>
              </tr>
            </tbody>
          </table>
    </div>
</div>




@endsection

@section('javascript')

@endsection