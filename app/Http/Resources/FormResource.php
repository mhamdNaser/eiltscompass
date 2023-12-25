<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormResource extends JsonResource
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
            'form_name' => $this->form_name,
            'type' => $this->type,
            'formula'=> $this->formula,
            "exam_time"=> $this->exam_time,
            "writer" => [
                "first_name" => $this->writer->first_name,
                "last_name" => $this->writer->last_name,
            ],
            'status'=> $this->status,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
