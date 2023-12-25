<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'image'         => 'nullable',
            'first_name'    => 'required|string|max:55',
            'last_name'     => 'required|string|max:55',
            'email'         => 'required|email|unique:users,email',
            'role'          => 'required|string|max:55',
            'country'       => 'required|string|max:55',
            'phone'         => 'required|string|max:13',
            'status'        => 'required|string|max:55',
            'password'      => 'required',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
