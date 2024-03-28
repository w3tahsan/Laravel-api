<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    function coupon(){
        $coupons = Coupon::all();
        return view('admin.coupon.coupon', [
            'coupons'=> $coupons,
        ]);
    }

    function coupon_store(Request $request){
        $request->validate([
            'type'=>'required',
        ]);
        Coupon::insert([
            'coupon'=>$request->coupon,
            'type'=>$request->type,
            'amount'=>$request->amount,
            'validity'=>$request->validity,
            'limit'=>$request->limit,
            'created_at'=>Carbon::now(),
        ]);
        return back();
    }

    function coupon_status($id){
        $coupon = Coupon::find($id);
        if($coupon->status == 1){
            Coupon::find($id)->update([
                'status' => 0,
            ]);
            return back();
        }
        else{
            Coupon::find($id)->update([
                'status' => 1,
            ]);
            return back();
        }
    }
}
