<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class QuestionResource extends JsonResource
{
    public static $wrap = false;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        // Get the file contents from storage based on the filename
        $fileContents = Storage::disk('local')->get('question/' . $this->content . '.php');

        return [
            'id' => $this->id,
            'type' => $this->type,
            'points' => $this->points,
            'content' => $fileContents,
            'form_exams_id' => $this->form_exams_id,
            // 'formExams' => $this->whenLoaded('formExams', function () {
            //     return $this->formExams->map(function ($FormExam) {
            //         return [
            //             'form_name'=> $FormExam->form_name,
            //             'type'=> $FormExam->type,
            //             'formula'=> $FormExam->formula
            //         ];
            //     });
            // }),
            'created_at' => $this->created_at->format('Y-m-d'),
            'answers' => $this->whenLoaded('answers', function () {
                return $this->answers->map(function ($answer) {
                    return [
                        'answer_content' => $answer->answer_content,
                        'answer_value' => $answer->answer_value,
                    ];
                });
            }),
        ];
    }
}
