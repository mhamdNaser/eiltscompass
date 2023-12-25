<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
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

        return [
            'id' => $this->id,
            'answer_content' => $this->answer_content,
            'matching' => $this->matching,
            'answer_value' => $this->answer_value,
            "question" => [
                "id"               => $this->question->id,
                "content"          => $this->question->content,
                "answer_value"     => $this->question->points,
                "type"             => $this->question->type
            ],
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
