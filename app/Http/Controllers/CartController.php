<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    function add_cart(Request $request){
        $request->validate([
            'color_id'=>'required',
            'size_id'=>'required',
        ]);

        Cart::insert([
            'customer_id'=>Auth::guard('customer')->id(),
            'product_id'=>$request->product_id,
            'color_id'=>$request->color_id,
            'size_id'=>$request->size_id,
            'quantity'=>$request->quantity,
            'created_at'=>Carbon::now(),
        ]);

        return back()->with('cart_added', 'Cart Added');
    }

    function cart_remove($id){
        Cart::find($id)->delete();
        return back();
    }

    function cart(Request $request){
        $coupon = $request->coupon;

        $mesg = '';
        $type = '';
        $amount = 0;

        if($coupon){
            if (Coupon::where('coupon', $coupon)->exists()) {
                if (Coupon::where('coupon', $coupon)->where('limit', '!=', 0)->exists()) {
                    if (Carbon::now()->format('Y-m-d') <= Coupon::where('coupon', $coupon)->first()->validity) {
                        $type = Coupon::where('coupon', $coupon)->first()->type;
                        $amount = Coupon::where('coupon', $coupon)->first()->amount;
                    } else {
                        $mesg = 'Coupon Expired!';
                        $amount = 0;
                    }
                } else {
                    $mesg = 'Coupon Limit Exceed!';
                    $amount = 0;
                }
            } else {
                $mesg = 'Coupon Does Not Exist';
                $amount = 0;
            }
        }



        $carts = Cart::where('customer_id', Auth::guard('customer')->id())->get();
        return view('frontend.cart', [
            'carts'=>$carts,
            'mesg'=> $mesg,
            'amount'=> $amount,
            'type'=> $type,
        ]);
    }

    function cart_update(Request $request){
        foreach($request->quantity as $cart_id=>$quantity){
            Cart::find($cart_id)->update([
                'quantity'=>$quantity,
            ]);
        }
        return back();
    }
}
