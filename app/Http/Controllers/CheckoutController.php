<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Shipping;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;

class CheckoutController extends Controller
{
    function checkout(){
        $countries =Country::all();
        $carts = Cart::where('customer_id', Auth::guard('customer')->id())->get();
        return view('frontend.checkout', [
            'carts'=> $carts,
            'countries'=> $countries,
        ]);
    }

    function getCity(Request $request){
        $str = '';
        $cities = City::where('country_id', $request->country_id)->get();
        foreach($cities as $city){
            $str .= '<option value="'. $city->id.'">'.$city->name.'</option>';
        }
        echo $str;
    }

    function order_store(Request $request){
        if($request->payment_method == 1){
            $order_id = '#'.uniqid().'-'.Carbon::now()->format('d-m-Y');
            if($request->ship_check == 1){
                $request->validate([
                    'ship_fname'=>'required',
                ]);

                Order::insert([
                    'order_id'=>$order_id,
                    'customer_id'=>Auth::guard('customer')->id(),
                    'total'=>$request->total+$request->charge,
                    'sub_total'=>$request->total-$request->discount,
                    'discount'=>$request->discount,
                    'charge'=>$request->charge,
                    'payment_method'=>$request->payment_method,
                    'created_at'=>Carbon::now(),
                ]);

                Billing::insert([
                    'order_id' => $order_id,
                    'customer_id' => Auth::guard('customer')->id(),
                    'fname' => $request->fname,
                    'lname' => $request->lname,
                    'country_id' => $request->country,
                    'city_id' => $request->city,
                    'zip' => $request->zip,
                    'company' => $request->company,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'notes' => $request->notes,
                    'created_at' => Carbon::now(),
                ]);

                Shipping::insert([
                    'order_id' => $order_id,
                    'ship_fname' => $request->ship_fname,
                    'ship_lname' => $request->ship_lname,
                    'ship_country_id' => $request->ship_country,
                    'ship_city_id' => $request->ship_city,
                    'ship_zip' => $request->ship_zip,
                    'ship_company' => $request->ship_company,
                    'ship_email' => $request->ship_email,
                    'ship_phone' => $request->ship_phone,
                    'ship_address' => $request->ship_address,
                    'created_at' => Carbon::now(),
                ]);
            }

            else{

                Order::insert([
                    'order_id'=>$order_id,
                    'customer_id'=>Auth::guard('customer')->id(),
                    'total'=>$request->total+$request->charge,
                    'sub_total'=>$request->total-$request->discount,
                    'discount'=>$request->discount,
                    'charge'=>$request->charge,
                    'payment_method'=>$request->payment_method,
                    'created_at'=>Carbon::now(),
                ]);

                Billing::insert([
                    'order_id' => $order_id,
                    'customer_id' => Auth::guard('customer')->id(),
                    'fname' => $request->fname,
                    'lname' => $request->lname,
                    'country_id' => $request->country,
                    'city_id' => $request->city,
                    'zip' => $request->zip,
                    'company' => $request->company,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'notes' => $request->notes,
                    'created_at' => Carbon::now(),
                ]);

                Shipping::insert([
                    'order_id' => $order_id,
                    'ship_fname' => $request->fname,
                    'ship_lname' => $request->lname,
                    'ship_country_id' => $request->country,
                    'ship_city_id' => $request->city,
                    'ship_zip' => $request->zip,
                    'ship_company' => $request->company,
                    'ship_email' => $request->email,
                    'ship_phone' => $request->phone,
                    'ship_address' => $request->address,
                    'created_at' => Carbon::now(),
                ]);
            }

            $carts = Cart::where('customer_id', Auth::guard('customer')->id())->get();
            foreach($carts as $cart){
                OrderProduct::insert([
                    'order_id'=>$order_id,
                    'customer_id' => Auth::guard('customer')->id(),
                    'product_id' => $cart->product_id,
                    'price' => $cart->rel_to_product->after_discount,
                    'color_id' => $cart->color_id,
                    'size_id' => $cart->size_id,
                    'quantity' => $cart->quantity,
                    'created_at' => Carbon::now(),
                ]);

                // Cart::find($cart->id)->delete();
                Inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quantity', $cart->quantity);
            }

            //sms
            $to_tal = $request->total+$request->charge;
            $url = "http://bulksmsbd.net/api/smsapi";
            $api_key = "K9YXIwC5K6nifLYd4XL3";
            $senderid = "8809617612585";
            $number = $request->phone;
            $message = "Congratulations Your order has been placed. please ready amount: $to_tal taka";

            $data = [
                "api_key" => $api_key,
                "senderid" => $senderid,
                "number" => $number,
                "message" => $message
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);

            Mail::to($request->email)->send(new InvoiceMail($order_id));

            return redirect()->route('order.success')->with('success', $order_id);


        }
        elseif($request->payment_method == 2){
            $data = $request->all();
            return redirect()->route('sslpay')->with('data', $data);
        }
        elseif($request->payment_method == 3){
            $data = $request->all();
            return redirect()->route('stripe')->with('data', $data);
        }
    }

    function order_success(){
        if(session('success')){
            return view('frontend.order_success');
        }
        else{
            abort('404');
        }
    }
}
