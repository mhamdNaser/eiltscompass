<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class StudentAnswerResource extends JsonResource
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
        $fileContents = Storage::disk('local')->get('question/' . $this->answers->question->content . '.php');

        return [
            'id'                => $this->id,
            'stu_ans_value'     => $this->stu_ans_value,
            'answer_id'         => $this->answer_id,
            'student_examing_id'=> $this->student_examing_id,
            'answer_content'    => $this->answer_content,
            'created_at'        => $this->created_at->format('Y-m-d'),
            "answers" => [
                "id"            => $this->answers->id,
                "answer_value"  => $this->answers->answer_value,
                "answer_content"=> $this->answers->answer_content,
                "question" => [
                    "id"        => $this->answers->question->id,
                    "content"   => $fileContents,
                    "points"    => $this->answers->question->points,
                    "type"    => $this->answers->question->type,
                ],
            ],
        ];
    }
}
