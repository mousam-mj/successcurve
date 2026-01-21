<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Classe;
use App\Testcatogerie;
use App\Testseriestest;
use App\Test;
use App\Tsenroll;
use App\Testenroll;
use App\Purchasetestseries;
use App\Coupon;
use App\Couponenroll;
use Carbon\Carbon;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

use Illuminate\Support\Facades\Mail;
use App\Mail\TsenrollMail;


class TestSeriesController extends Controller
{
    
    public function testSeriesDetails($id){
        $ts = Testcatogerie::join('classes', 'classes.classId', '=', 'testcatogeries.tcClass')
        ->join('users', 'users.id', '=', 'testcatogeries.created_by')
        ->select('testcatogeries.*', 'users.name as userName', 'classes.className as className')
        ->where('tcId', $id)->first();

        if (!empty($ts)) {

            $tse = Tsenroll::where('tsId', $id)->where('uId', Session::get('userId'))->first();
    
            $enrolls = 0;
            
            if(!empty($tse)){
                if ($tse->expires_at == null) {
                    $enrolls = 1;
                } elseif ($tse->expires_at > Carbon::now()) {
                    $enrolls = 1;
                }
            }
            
            $tsts = Testseriestest::join('tests', 'testseriestests.tId', '=', 'tests.tId')
                ->select('testseriestests.tstId', 'tests.*')
                ->where('tcId', $id)
                ->orderBy('tId', 'DESC')
                ->get();

            return View('TestSeries/testSeriesDetails',['enrolls'=>$enrolls, 'ts'=>$ts, 'tsts'=>$tsts]);

        } else {
            return back()->with('Invalid Test Series Id given..');
        }
    }

    
    function enrollTestSeries($id){
        $tse = Tsenroll::where('tsId', $id)->where('uId', Session::get('userId'))->first();
        $ts = Testcatogerie::where('tcId', $id)->first();
        $tss = $ts;
        if(empty($tse)){
            
            $ts->enrolls +=1;
            $ts->save();

            $tse = new Tsenroll;
            $tse->tsId = $id;
            $tse->uId = Session::get('userId');
            $tse->save();
            $curl = 'https://successcurve.in/testSeriesDetails/'.$tss->tcId;
            $data= [
                'name'=>Session::get('user'),
                'tstitle'=>$tss->tcName,
                'tsURL'=>$curl
            ];
            Mail::to(Session::get('userEmail'))->send(new TsenrollMail($data));
        }

        return redirect('testSeriesDetails/'.$tss->tcId);
}

    public function purchaseTS(Request $req){
        $ts = Testcatogerie::where('tcId', $req->tsId)->first();

        if(!empty($ts) && $ts->tcPrice != null && $ts->tcPrice > 0){
            $buyc = Purchasetestseries::where('tcId', $req->tsId)->where('userId', Session::get('userId'))->where('paymentStatus', 0)->first();
            
            $data = [];

            /*
                - Check Coupon code is entered or not.
                - Check whether the coupon code is expired or not.
                - check coupon code uses type 
                - check coupon code use limit
                - check coupon code have used erlier or not.
            */

            $isValidCoupon = false;
            $coupon = null;
            if ($req->couponCode != null && $req->couponCode != '') {

                $coupon = Coupon::where('cpCode', $req->couponCode)->first();
                if (!empty($coupon) && $coupon->expires_at > Carbon::now()){

                    if ($coupon->cpFor == 1 || $coupon->cpFor == 4) {

                        $cenroll = Couponenroll::where('userId', Session::get('userId'))->where('cpId', $coupon->cpId)->count();
                        if ($cenroll < $coupon->cpLimit) {
                            
                            $isValidCoupon = true;
                        }
                    }
                    
                }   
            }

            if(!empty($buyc)){
                if ($isValidCoupon) {
                    // dd('valid coupon');
                    if ($buyc->couponCode != null && $buyc->couponCode == $req->couponCode && $buyc->created_at > $ts->updated_at) {

                        // if the coupon code was applied erlier and now are same  

                        $data = [
                            'orderId'=>$buyc->orderId,
                            'amount' => $buyc->amount,
                            'name'=> $ts->tcName,
                            'key'=>config("razor.razor_key"),
                        ];
                    } else{

                        // if the coupon code was applied erlier and now are not same 

                        $amount = $ts->tcPrice - floor(($ts->tcPrice * $coupon->cpDiscount) / 100);
                        
                        $api = new Api(config('razor.razor_key'), config('razor.razor_secret'));
                        $order  = $api->order->create(array('receipt' => '123', 'amount' => $amount * 100 , 'currency' => 'INR')); // Creates order
                        $orderId = $order['id'];

                        $pur = new Purchasetestseries();
                        $pur->userId = Session::get('userId');
                        $pur->tcId = $req->tsId;
                        $pur->couponCode = $req->couponCode;
                        $pur->amount = $amount;
                        $pur->orderId = $orderId;
                        $pur->save();
                        $data = [
                            'orderId'=>$orderId,
                            'amount' => $amount,
                            'name'=>$ts->tcName,
                            'key'=>config("razor.razor_key"),
                        ];
                    }
                } else {
                    // dd('invalid coupon');
                    // if the coupon code was in not valid

                    if ($buyc->couponId == null && $buyc->created_at > $ts->updated_at) {

                        // if the coupon code is & was not applied

                        $data = [
                            'orderId'=>$buyc->orderId,
                            'amount' => $buyc->amount,
                            'name'=>$ts->tcName,
                            'key'=>config("razor.razor_key"),
                        ];
                    } else{
                        $amount = $ts->tcPrice;
                        
                        $api = new Api(config('razor.razor_key'), config('razor.razor_secret'));
                        $order  = $api->order->create(array('receipt' => '123', 'amount' => $amount * 100 , 'currency' => 'INR')); // Creates order
                        $orderId = $order['id'];

                        $pur = new Purchasetestseries();
                        $pur->userId = Session::get('userId');
                        $pur->tcId = $req->tsId;
                        $pur->amount = $amount;
                        $pur->orderId = $orderId;
                        $pur->save();
                        $data = [
                            'orderId'=>$orderId,
                            'amount' => $amount,
                            'name'=>$ts->tcName,
                            'key'=>config("razor.razor_key"),
                        ];
                    }
                }
                
            }else{
                
                // dd($pck);
                 $amount = $ts->tcPrice;
                
                 if($isValidCoupon){
                    $amount = $ts->tcPrice - floor(($ts->tcPrice * $coupon->cpDiscount) / 100);
                }
                
                $api = new Api(config('razor.razor_key'), config('razor.razor_secret'));
                $order  = $api->order->create(array('receipt' => '123', 'amount' => $amount * 100 , 'currency' => 'INR')); // Creates order
                $orderId = $order['id'];

                $pur = new Purchasetestseries();
                $pur->userId = Session::get('userId');
                $pur->tcId = $req->tsId;

                if ($isValidCoupon) {
                    $pur->couponCode = $req->couponCode;
                }

                $pur->amount = $amount;
                $pur->orderId = $orderId;
                $pur->save();
                $data = [
                    'orderId'=>$orderId,
                    'amount' => $amount,
                    'name'=>$ts->tcName,
                    'key'=>config("razor.razor_key"),
                ];
            }

            // dd($ts);

            // dd($data);
            return view('buyTestSeries',['tss'=>$ts, 'datas'=>$data]);
        }
    }
    public function payTS(Request $req){
        $data = $req->all();
        $tsPurchase = Purchasetestseries::where('orderId', $data['razorpay_order_id'])->first();
        $tsPurchase->paymentStatus = 1;
        $tsPurchase->paymentId = $data['razorpay_payment_id'];

        $api = new Api(config('razor.razor_key'), config('razor.razor_secret'));


        try{
            $attributes = array(
                'razorpay_signature' => $data['razorpay_signature'],
                'razorpay_payment_id' => $data['razorpay_payment_id'],
                'razorpay_order_id' => $data['razorpay_order_id']
            );
            $order = $api->utility->verifyPaymentSignature($attributes);
            $success = true;
        }catch(SignatureVerificationError $e){

            $succes = false;
        }

        $tsId = $tsPurchase->tcId;
        if($success){
            $c = Testcatogerie::where('tcId', $tsId)->first();

            $validity = Carbon::now()->addMonths($c->tcValidity);

            $tsPurchase->expires_at = $validity;

            $tsPurchase->save();

            if ($tsPurchase->couponCode != null) {
                $coupon = Coupon::where('cpCode', $tsPurchase->couponCode)->first();

                if (!empty($coupon)) {
                    $coupon->cpUsed += 1;
                    $coupon->save();
                }

                $cpe = new Couponenroll();
                $cpe->cpId  = $coupon->cpId;
                $cpe->userId = Session::get('userId');
                $cpe->usedFor = 3;
                $cpe->save();
            }

            $ce = new tsenroll();
            $ce->tsId = $tsId;
            $ce->uId = Session::get('userId');
            $ce->expires_at = $validity;
            $ce->save();

            $tests = Testseriestest::where('tcId', $tsId)->get();
            
            foreach ($tests as $test) {
                $ce = new Testenroll();
                $ce->testId = $test->tId;
                $ce->userId = Session::get('userId');
                $ce->enrollType = 1;
                $ce->expires_at = $validity;
                $ce->save();
            }
            
            return redirect('testSeriesDetails/'.$tsId);
        }else{
            return redirect('paymentFailed');
        }
    }

    public function testseriesPayments($id ) {
        $tss = Testcatogerie::where('tcId', $id)->first();
        if (!empty($tss)) {
            $pcs = Purchasetestseries::join('users', 'users.id', '=', 'purchasetestseries.userId')
            ->select('purchasetestseries.*', 'users.name as userName', 'users.contact as userContact')
            ->where('tcId', $id)
            ->where('paymentStatus', 1)
            ->orderBy('pcId', 'desc')
            ->get();

            return view('Admin/payments/testseriesPayments', ['tss'=>$tss, 'pcs'=>$pcs]);
        }
        return back()->with('errors', 'Invalid Test Series Id..');
    }

    function testSeries(){

        $pts = Testcatogerie::join('classes', 'testcatogeries.tcClass', '=', 'classes.classId')
            ->select('testcatogeries.*', 'classes.className as className')
            ->where('isPopular', '1')
            ->where('tcStatus', 1)
            ->orderBy('tcId', 'DESC')
            ->get();

        $cls = Classe::get();

        $classes = [];
        $i = 0;
        foreach($cls as $cl){
            $tss = Testcatogerie::join('classes', 'testcatogeries.tcClass', '=', 'classes.classId')
            ->select('testcatogeries.*', 'classes.className as className')
            ->where('tcClass', $cl->classId)
            ->where('tcStatus', 1)
            ->orderBy('tcName', 'ASC')
            ->take(8)
            ->get();

            if (!empty($tss) && count($tss) > 0){
                $classes[$i]['class'] = $cl;
                $classes[$i]['testSeries'] = $tss;

                $i++;
            }
        }

        

        return View('TestSeries/testSeries',['pts'=>$pts, 'classes'=>$classes]);
    }

    function allTestSeriesByClass($id) {
        $cls = Classe::where('classId', $id)->first();
        $tss = Testcatogerie::join('classes', 'testcatogeries.tcClass', '=', 'classes.classId')
            ->select('testcatogeries.*', 'classes.className as className')
            ->where('tcClass', $id)
            ->where('tcStatus', 1)
            ->orderBy('tcName', 'ASC')
            ->paginate(12);

        return view('TestSeries.allTestSeries', ['testseries'=>$tss, 'class'=>$cls]);
    }

    function testSeriesTests($id){
        $tcs = Testcatogerie::where('tcId',$id)->first();
//        dd($tcs);
        $tsts = Testseriestest::join('tests', 'testseriestests.tId', '=', 'tests.tId')
            ->select('testseriestests.tstId', 'tests.*')
            ->where('tcId', $id)
            ->orderBy('tId', 'ASC')
            ->get();
//        dd($tsts);

        return View('Admin/testSeriesTest', ['tcs'=>$tcs, 'tsts'=>$tsts]);
    }

    function addTestToSeries($id){
         $tcs = Testcatogerie::where('tcId',$id)->first();


        return View('Admin/addTestToSeries',['tcs'=>$tcs]);
    }

    function getTestsLists(Request $req){
        $tsId = $req->tcId;
        $classId = $req->classId;
        $subjectId = $req->subjectId;
        $tques = Testseriestest::select('tId')->where('tcId', $tsId)->get();

        $qsid = [];
        $count = 0;
        foreach($tques as $qid){
            $qsid[$count++] = $qid->tId;
        }

        $tests = [];
        if(empty($qsid))
        {
            $tests = Test::where('tClass', $classId)
            ->where('tSubject', $subjectId)
            ->orderBy('tId','ASC')
            ->get();
//            dd($tests);
        }
        else{
            $tests = Test::where('tClass', $classId)
            ->where('tSubject', $subjectId)
            ->whereNotIn('tId', $qsid)
            ->orderBy('tId','ASC')
            ->get();
        }

        return json_encode(array('data'=>$tests));
    }



    function addTestList(Request $req){
        $tsId = $req->tsId;
         $tId = $req->tId;
         $subjectId = $req->subId;
         $classId = $req->clsId;

        $tst = new Testseriestest;
        $tst->tcId = $tsId;
        $tst->tId = $tId;
        $tst->save();

        $ts = Testcatogerie::where('tcId', $tsId)->first();

        $ts->noOfTests +=1;
        $ts->save();

       $tques = Testseriestest::select('tId')->where('tcId', $tsId)->get();

        $qsid = [];
        $count = 0;
        foreach($tques as $qid){
            $qsid[$count++] = $qid->tId;
        }

        $tests = [];
        if(empty($qsid))
        {
            $tests = Test::where('tClass', $classId)
            ->where('tSubject', $subjectId)
            ->orderBy('tId','ASC')
            ->get();
            dd($tests);
        }
        else{
            $tests = Test::where('tClass', $classId)
            ->where('tSubject', $subjectId)
            ->whereNotIn('tId', $qsid)
            ->orderBy('tId','ASC')
            ->get();
        }

        return json_encode(array('data'=>$tests));
    }

    function removeTestFromSeries($tstId, $tId){
        $tst = Testseriestest::where('tstId', $tstId)->first();

        $ts = Testcatogerie::where('tcId', $tst->tcId)->first();
        $ts->noOfTests -= 1;
        $ts->save();

        $tsts = Testseriestest::where('tstId', $tstId)->delete();

        return redirect('admin/testSeriesTests/'.$tst->tcId);
    }


    public function editTS($id){
        $tcs = Testcatogerie::where('tcId', $id)->first();
        return view('Admin/tests/editTS', ['tcs'=>$tcs]);
    }

}
