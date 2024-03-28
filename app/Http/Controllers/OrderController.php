<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderCancel;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class OrderController extends Controller
{
    function orders(){
        $orders = Order::latest()->get();
        return view('admin.orders.order', [
            'orders'=>$orders,
        ]);
    }

    function order_status_update(Request $request, $id){
        Order::find($id)->update([
            'status'=>$request->status,
        ]);
        return back();
    }

    function cancel_order($id){
        $order_info = Order::find($id);
        return view('frontend.customer.cancel_order', [
            'order_info'=>$order_info,
        ]);
    }
    function cancel_order_req(Request $request, $id){
        if($request->image == ''){
            OrderCancel::insert([
                'order_id'=>$id,
                'reason'=>$request->reason,
                'created_at'=>Carbon::now(),
            ]);
            return back()->with('req', 'Order Cancel Request Sent');
        }
        else{
            $image = $request->image;
            $extension = $image->extension();
            $file_name = random_int(10000, 90000).'.'.$extension;
            Image::make($image)->save(public_path('uploads/cancelorder/'.$file_name));
            OrderCancel::insert([
                'order_id'=>$id,
                'reason'=>$request->reason,
                'image'=>$file_name,
                'created_at'=>Carbon::now(),
            ]);
            return back()->with('req', 'Order Cancel Request Sent');
        }
    }

    function cancel_order_list(){
        $order_cancel_lists = OrderCancel::all();
        return view('admin.orders.cancel_order_list', [
            'order_cancel_lists'=>$order_cancel_lists,
        ]);
    }

    function cancel_details($id){
        $details = OrderCancel::find($id);
        return view('admin.orders.cancel_details', [
            'details'=>$details,
        ]);
    }
    function cancel_accept($id){
        $details = OrderCancel::find($id);
        Order::find($details->order_id)->update([
            'status'=>5,
        ]);
        $order_id = Order::find($details->order_id);
        foreach(OrderProduct::where('order_id', $order_id->order_id)->get() as $order_product){
            Inventory::where('product_id', $order_product->product_id)->where('color_id', $order_product->color_id)->where('size_id', $order_product->size_id)->increment('quantity', $order_product->quantity);
        }
        OrderCancel::find($id)->delete();
        return back();
    }
}