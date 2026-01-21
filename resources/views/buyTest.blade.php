@extends('layout')

@section('title')
Purchase Test: {{ $tests->tName }}
@endsection
@section('content')

<div class="purcboxmain">
    <div class="purcbox">
        <h2 class="purch1">Test Details</h2>
        <table class="table table-bordered mt-3">
            <thead>
              <tr>
                <th scope="col">Key</th>
                <th scope="col">Details</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Test Name</td>
                <td>{{ $tests->tName }}</td>
              </tr>
              <tr>
                <td>Test Instructor</td>
                <td>{{ $tests->userName }}</td>
              </tr>
              <tr>
                <td>Course Price</td>
                <td>RS {{ $datas['amount'] }}</td>
              </tr>
              <tr>
                <td>Course Validity</td>
                <td>{{ $tests->tValidity }} Months </td>
              </tr>
              <tr>
                <td colspan="2" class="text-center">
                    <form action="{{ url('payTest') }}" method="POST" class="text-center mx-auto ">
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