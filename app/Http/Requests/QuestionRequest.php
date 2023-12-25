<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
            'form_exams_id' => 'required|exists:form_exams,id',
            'content'       => 'required|string',
            'type'          => 'required|string',
            'points'        => 'required|string',
            'answer'        => 'required|array', // Check if answer is an array
            'answer.*.answer_content' => 'required|string', // Validate each answer_content in the array
            'answer.*.answer_value'   => 'required|boolean', // Validate each answer_value in the array
        ];
    }
}
