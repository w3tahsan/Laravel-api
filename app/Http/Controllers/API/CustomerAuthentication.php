<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Throwable;

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

        $token = $customers->createToken('API TOKEN')->plainTextToken;

        $response = [
            'success'=> 'Customer Registered Success',
            'customers'=> $customers,
            'token'=>$token,
        ];
        return response()->json($response);

    }

    function customer_login(Request $request){
        try{

            $validation = Validator::make($request->all(),[
                'email' => ['required'],
                'password' => ['required']
            ]);

            if($validation->fails()){
                return response()->json([
                    'status' => 401,
                    'message' => 'validation failed',
                    'errors' => $validation->errors()->all(),
                ],401);
            }else{
                if(!Auth::guard('customer')->attempt(['email'=>$request->email, 'password'=>$request->password])){
                return response()->json([
                    'status' => 401,
                    'message' => 'creadential not match',
                ],401);
                }else{
                    $user = Customer::where('email',$request->email)->first();
                    $token = $user->createToken("API TOKEN")->plainTextToken;
                return response()->json([
                    'status' => 200,
                    'email' => $request->email,
                    'message' => 'login successfull',
                    'token' => $token,
                ],200);
                }

            }

        }catch(Throwable $th){
            return response()->json([
                'message' => $th->getMessage(),
            ]);
        }

    }

    function customer_logout(Request $request){
        $accessToken = $request->bearerToken();
        $token = PersonalAccessToken::findToken($accessToken);
        $token->delete();
        return response(['message' => 'customer Logout success']);

    }

}
