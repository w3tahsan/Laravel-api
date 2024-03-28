<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerEmailVerify;
use App\Notifications\EmailVerifyNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\RedirectResponse;
use App\Rules\ReCaptcha;

class CustomerAuthController extends Controller
{
    function customer_login()
    {
        return view('frontend.customer.login');
    }
    function customer_register()
    {
        return view('frontend.customer.register');
    }

    function customer_store(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'email' => 'required|unique:customers',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'password_confirmation' => 'required',
            'captcha' => 'required|captcha',
        ]);

        $customer_info = Customer::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'created_at' => Carbon::now(),
        ]);

        CustomerEmailVerify::where('customer_id', $customer_info->id)->delete();
        $info = CustomerEmailVerify::create([
            'customer_id'=>$customer_info->id,
            'token'=>uniqid(),
            'created_at'=>Carbon::now(),
        ]);

        Notification::send($customer_info, new EmailVerifyNotification($info));

        return back()->with('success', 'Customer Registered Successfully, Please Verify your email');
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }

    function customer_logged(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'g-recaptcha-response' => ['required', new ReCaptcha]
        ]);

        if (Customer::where('email', $request->email)->exists()) {
            if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
                if(Auth::guard('customer')->user()->email_verified_at == null){
                    Auth::guard('customer')->logout();
                    return redirect()->route('customer.login')->with('verify_email', 'Please Verify your email first');
                }
                else{
                    return redirect()->route('index');
                }
            } else {
                return back()->with('wrong', 'Wrong Credential');
            }
        } else {
            return back()->with('exist', 'Email Does Not Exist');
        }
    }
    function githubredirect_login()
    {
        return Socialite::driver('github')->redirect();
    }
    function githubcallback_login()
    {
        $githubUser  = Socialite::driver('github')->user();
        Customer::updateOrCreate(
            [
                'email' => $githubUser->email,
            ],
            [
                'fname' => $githubUser->name,
                'lname' => $githubUser->name,
                'email' => $githubUser->email,
                'password' => bcrypt(123456),
                'created_at' => Carbon::now(),
            ]
        );

        Auth::guard('customer')->attempt(['email' => $githubUser->email, 'password' => 123456]);
        return redirect()->route('index');
    }
    function googleredirect_login()
    {
        return Socialite::driver('google')->redirect();
    }
    function googlecallback_login()
    {
        $googleUser  = Socialite::driver('google')->user();
        Customer::updateOrCreate(
            [
                'email' => $googleUser->email,
            ],
            [
                'fname' => $googleUser->name,
                'lname' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => bcrypt(123456),
                'created_at' => Carbon::now(),
            ]
        );

        Auth::guard('customer')->attempt(['email' => $googleUser->email, 'password' => 123456]);
        return redirect()->route('index');
    }
}
