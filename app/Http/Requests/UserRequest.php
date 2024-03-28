<?php

namespace App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'current_password'=>'required',
            'password'=>
            [
                'required', 
                'confirmed', 
                Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
            ],
            'password_confirmation'=>'required',
        ];
    }
    public function messages(): array
    {
        return [
            'current_password.required'=>'oi Bortoman Password De',
            'password.required'=>'Noya Password De',
            'password_confirmation.required'=>'Abar Password De',
        ];
    }
}
