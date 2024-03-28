<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerEmailVerify;
use App\Models\Order;
use App\Notifications\EmailVerifyNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Intervention\Image\Facades\Image;
use PDF;

class CustomerController extends Controller
{

    function __construct()
    {
        $this->middleware('customer');
    }
    
    function customer_profile(){
        return view('frontend.customer.profile');
    }

    function customer_logout(){
        Auth::guard('customer')->logout();
        return redirect()->route('index')->with('ja', 'You Are logged out');
    }
    function profile_update(Request $request){
        if($request->password == ''){
            if($request->image == ''){
                Customer::find(Auth::guard('customer')->id())->update([
                    'fname'=>$request->fname,
                    'lname'=>$request->lname,
                    'phone'=>$request->phone,
                    'zip'=>$request->zip,
                    'address'=>$request->address,
                    'updated'=>Carbon::now(),
                ]);
                return back();
            }
            else{
                if (Auth::guard('customer')->user()->photo != null) {
                    $current = public_path('uploads/customer/' . Auth::guard('customer')->user()->photo);
                    unlink($current);
                }
                $img = $request->image;
                $extension = $img->extension();
                $file_name = Auth::guard('customer')->id().'.'.$extension;
                Image::make($img)->save(public_path('uploads/customer/'.$file_name));
                Customer::find(Auth::guard('customer')->id())->update([
                    'fname' => $request->fname,
                    'lname' => $request->lname,
                    'phone' => $request->phone,
                    'zip' => $request->zip,
                    'address' => $request->address,
                    'photo' => $file_name,
                    'updated' => Carbon::now(),
                ]);
                return back();
            }
        }
        else{
            if ($request->image == '') {
                Customer::find(Auth::guard('customer')->id())->update([
                    'fname' => $request->fname,
                    'lname' => $request->lname,
                    'phone' => $request->phone,
                    'zip' => $request->zip,
                    'address' => $request->address,
                    'password' => bcrypt($request->password),
                    'updated' => Carbon::now(),
                ]);
                return back();
            }

            else {
                if(Auth::guard('customer')->user()->photo != null){
                    $current = public_path('uploads/customer/' . Auth::guard('customer')->user()->photo);
                    unlink($current);
                }
                $img = $request->image;
                $extension = $img->extension();
                $file_name = Auth::guard('customer')->id() . '.' . $extension;
                Image::make($img)->save(public_path('uploads/customer/' . $file_name));
                Customer::find(Auth::guard('customer')->id())->update([
                    'fname' => $request->fname,
                    'lname' => $request->lname,
                    'phone' => $request->phone,
                    'zip' => $request->zip,
                    'address' => $request->address,
                    'photo' => $file_name,
                    'password' => bcrypt($request->password),
                    'updated' => Carbon::now(),
                ]);
                return back();
            }
        }
    }

    function my_orders(){
        $my_orders = Order::where('customer_id', Auth::guard('customer')->id())->latest()->get();
        return view('frontend.customer.my_orders', [
            'my_orders'=>$my_orders,
        ]);
    }
    function download_invoice($id){
        $orders = Order::find($id);
        $pdf = PDF::loadView('frontend.customer.invoicedownload', [
            'order_id'=>$orders->order_id,
        ]);
        return $pdf->stream('myorders.pdf');
    }

    function customer_email_verify($token){

        if(CustomerEmailVerify::where('token', $token)->exists()){
            $verify_info = CustomerEmailVerify::where('token', $token)->first();

            Customer::find($verify_info->customer_id)->update([
                'email_verified_at'=>Carbon::now(),
            ]);

            CustomerEmailVerify::where('token', $token)->delete();

            return redirect()->route('customer.login')->with('verify', 'Email verified success');
        }
        else{
            abort('404');
        }
    }

    function resend_email_verify(){
        return view('frontend.customer.resend_email_verify');
    }

    function resend_link_send(Request $request){
        $customer = Customer::where('email', $request->email)->first();
        if(Customer::where('email', $request->email)->exists()){
            CustomerEmailVerify::where('customer_id', $customer->id)->delete();
            $info = CustomerEmailVerify::create([
                'customer_id'=>$customer->id,
                'token'=>uniqid(),
                'created_at'=>Carbon::now(),
            ]);

            Notification::send($customer, new EmailVerifyNotification($info));

            return back()->with('success', 'We have sent you verififaction link, Please Verify your email');
        }
        else{
            return back()->with('notexist', 'Email Does Not Exist');
        }
    }
}
