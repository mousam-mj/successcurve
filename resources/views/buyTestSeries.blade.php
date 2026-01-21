@extends('layout')

@section('title')
Purchase Test Series: {{ $tss->tcName }}
@endsection
@section('content')

<div class="purcboxmain">
    <div class="purcbox">
        <h2 class="purch1">Test Series Details</h2>
        <table class="table table-bordered mt-3">
            <thead>
              <tr>
                <th scope="col">Key</th>-
                <th scope="col">Details</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Test Series Name</td>
                <td>{{ $tss->tcName }}</td>
              </tr>
              <tr>
                <td>Tests Available</td>
                <td>{{ $tss->noOfTests }}</td>
              </tr>
              <tr>
                <td>Course Price</td>
                <td>RS {{ $datas['amount'] }}</td>
              </tr>
              <tr>
                <td>Course Validity</td>
                <td>{{ $tss->tcValidity }} Months </td>
              </tr>
              <tr>
                <td colspan="2" class="text-center">
                    <form action="{{ url('payTestSeries') }}" method="POST" class="text-center mx-auto ">
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