<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartApiController extends Controller
{
    function cart_store(Request $request){
        $carts = Cart::create([
            'customer_id' => $request->customer_id,
            'product_id' => $request->product_id,
            'color_id' => $request->color_id,
            'size_id' => $request->size_id,
            'quantity' => $request->quantity,
            'created_at' => Carbon::now(),
        ]);
        $response = [
            'carts'=> $carts,
            'message' => 'Cart Added Successfully',
        ];
        return response()->json($response);
    }


}
