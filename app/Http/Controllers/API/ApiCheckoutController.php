<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Cart;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiCheckoutController extends Controller
{
    function checkout_store(Request $request)
    {
        if ($request->payment_method == 1) {
            $order_id = '#' . uniqid() . '-' . Carbon::now()->format('d-m-Y');

            //order
            Order::insert([
                'order_id' => $order_id,
                'customer_id' => $request->customer_id,
                'total' => $request->total + $request->charge,
                'sub_total' => $request->total - $request->discount,
                'discount' => $request->discount,
                'charge' => $request->charge,
                'payment_method' => $request->payment_method,
                'created_at' => Carbon::now(),
            ]);

            Billing::insert([
                'order_id' => $order_id,
                'customer_id' => $request->customer_id,
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

            $carts = Cart::where('customer_id', $request->customer_id)->get();
            foreach ($carts as $cart) {
                OrderProduct::insert([
                    'order_id' => $order_id,
                    'customer_id' => $request->customer_id,
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


            $response = [
                'message' => 'Order Placed Successfully!',
            ];
            return response()->json($response);
        } else if ($request->payment_method == 2) {
        }
    }
}
