<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnswerRequest extends FormRequest
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
            'form_exams_id'     => 'required|exists:form_exams,id',
            'answer_content'    => 'required|string',
            'matching'          => 'string|max:55',
            'answer_value'      => 'required|string',
        ];
    }
}
