<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;

use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    public function getCoupons() {
        $coupons = Coupon::all();

        return view('Admin/coupons/coupons', ['coupons'=>$coupons]);
    }

    public function newCoupon(){
        return view('Admin/coupons/addCoupon');
    }

    public function addCoupon(Request $req){
        $coupon = new Coupon();
        $coupon->cpName = $req->name;
        $coupon->cpCode = $req->code;
        $coupon->cpDiscount = $req->discount;
        $coupon->cpLimit = $req->limit;
        $coupon->cpFor = $req->cfor;
        $coupon->expires_at = $req->expire;
        $coupon->created_by = Session::get('auserId');
        $coupon->save();

        return redirect('admin/coupons')->with('success', 'Coupon Added Successfully..');
    }

    public function editCoupon($id){
        $coupon = Coupon::where('cpId', $id)->first();

        if (!empty($coupon)) {
            return view('Admin/coupons/editCoupon', ['coupon'=>$coupon]);
        } else {
            return back()->with("errors", 'Invalid Coupon Id!');
        }
    }

    public function updateCoupon(Request $req){
        $coupon = Coupon::where('cpId', $req->couponId)->first();
        $coupon->cpName = $req->name;
        $coupon->cpCode = $req->code;
        $coupon->cpDiscount = $req->discount;
        $coupon->cpLimit = $req->limit;
        $coupon->cpFor = $req->cfor;
        
        if ($req->expire) {
            $coupon->expires_at = $req->expire;
        }
        
        $coupon->created_by = Session::get('auserId');
        $coupon->save();

        return redirect('admin/coupons')->with('success', 'Coupon Updated Successfully..');
    }
}
