<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentAnswerRequest extends FormRequest
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
            // 'stu_ans_value'             => 'required|string',
            // 'answer_id'                 => 'required|exists:answers,id',
            // 'answer_content'            => 'required|string',
            'student_examing_id'        => 'required|exists:student_examings,id',
        ];
    }
}
