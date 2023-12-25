<?php

namespace App\Http\Requests\Exam;

use Illuminate\Foundation\Http\FormRequest;

class FormExamRequest extends FormRequest
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
            'form_name' => 'required|string|max:55|unique:form_exams,form_name',
            'type' => 'required|string|max:55',
            'formula' => 'required|string|max:55',
            'status' => 'string|max:55',
            'exam_time'=> 'required|string',
            'writer_id'=> 'required|integer'
        ];
    }
}