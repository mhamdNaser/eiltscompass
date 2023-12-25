<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamingRequest extends FormRequest
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
            'student_id'                        => 'required|exists:users,id',
            'form_exams_id'                     => 'required|exists:form_exams,id',
            'fullmark'                          => 'required|integer',
            'allAnswers'                        => 'array', // Check if answer is an array
            'allAnswers.*.answer_id'            => 'integer', // Validate each answer_content in the array
            'allAnswers.*.stu_ans_value'        => 'boolean',
            'allAnswers.*.answer_content'       => 'string',
            'allAnswers.*.audio_file'           => 'file|mimes:mp3,wav', 
        ];

    }
}
