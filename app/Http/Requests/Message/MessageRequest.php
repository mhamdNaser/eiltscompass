<?php

namespace App\Http\Requests\Message;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            "user_id"   => 'required|exists:users,id',
            'name'      => 'required|string',
            'email'     => 'required|string',
            'subject'   => 'required|string',
            "content"   => 'required|string',
        ];
    }
}