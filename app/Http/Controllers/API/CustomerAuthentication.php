<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class CustomerAuthentication extends Controller
{
    function customer_register(Request $request){
        $validator = Validator::make($request->all(),[
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
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }

        $customers = Customer::create([
            'fname'=>$request->fname,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);

        $token = $customers->createToken('hudaitoken')->plainTextToken;

        $response = [
            'success'=> 'Customer Registered Success',
            'customers'=> $customers,
            'token'=>$token,
        ];
        return response()->json($response);

    }

    function customer_login(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required',
        ]);

        $customers = Customer::where('email', $request->email)->first();

        if (Customer::where('email', $request->email)->exists()) {
            if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
                $token = $customers->createToken('hudaitoken')->plainTextToken;
                $response = [
                    'success'=> 'Customer Login Success',
                    'email'=> $customers->email,
                    'token'=>$token,
                ];
                return response()->json($response);
            }
            else {
                return response(['Error' => 'Wrong Password']);
            }
        }
        else {
            return response(['Error' => 'email does not exist']);
        }
    }

    function customer_logout(Request $request){
        $accessToken = $request->bearerToken();
        $token = PersonalAccessToken::findToken($accessToken);
        $token->delete();
        return response(['message' => 'customer Logout success']);

    }

}
