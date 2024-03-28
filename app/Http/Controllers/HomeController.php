<?php

namespace App\Http\Controllers;

use App\Models\Subscribe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
class HomeController extends Controller
{
    function dashboard(){
        return view('dashboard');
    }
    function user_list(){
        $users = User::where('id', '!=', Auth::id())->get();
        return view('admin.user.user_list', compact('users'));
    }
    function user_delete($user_id){
        User::find($user_id)->delete();
        return back()->with('delete', 'User Deleted Successfully');
    }

    function user_add(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
            'password'=>Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols(),
            'confirm_password'=>'required',
        ]);

        if($request->password != $request->confirm_password){
            return back()->with('match', 'Password and Confirm Password Does not Match');
        }
        // User::insert([
        //     'name'=>$request->name,
        //     'email'=>$request->email,
        //     'password'=>bcrypt($request->password),
        // ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password'=>bcrypt($request->password),
        ]);
        event(new Registered($user));
        return back()->with('success', 'New User Added!');
    }

    function subscribe(){
        $subscribers  = Subscribe::all();
        return view('admin.subscribe.subscribe', [
            'subscribers'=>$subscribers,
        ]);
    }
}