<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Passreset;
use App\Notifications\PassResetNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PassResetController extends Controller
{
    function forget_password(){
        return view('frontend.password_reset.password_reset');
    }
    function pass_reset_req(Request $request){
        $request->validate([
            'email'=>'required',
        ]);

        if(Customer::where('email', $request->email)->exists()){
            $customer = Customer::where('email', $request->email)->first();
            Passreset::where('customer_id', $customer->id)->delete();
            $info = Passreset::create([
                'customer_id'=>$customer->id,
                'token'=>uniqid(),
                'created_at'=>Carbon::now(),
            ]);

            Notification::send($customer, new PassResetNotification($info));


            return back()->with('sent', "We have sent you a password reset link, on $customer->email");
        }
        else{
            return back()->with('exist', 'Email does not exist');
        }
    }

    function password_reset_form($token){
        if(Passreset::where('token', $token)->exists()){
            return view('frontend.password_reset.pass_reset_form', [
                'token'=>$token,
            ]);
        }
        else{
            abort('404');
        }

    }

    function password_reset_confirm(Request $request, $token){
        $passreset = Passreset::where('token', $token)->first();
        if(Passreset::where('token', $token)->exists()){
            Customer::find($passreset->customer_id)->update([
                'password'=>bcrypt($request->password),
            ]);
            Passreset::where('token', $token)->delete();
            return redirect()->route('customer.login')->with('reset', 'Password Reset Success!');
        }
        else{
            abort('404');
        }
    }

}