<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamingResource extends JsonResource
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
            'id'            => $this->id,
            'correction'    => $this->correction,
            'result'        => $this->result,
            'fullmark'        => $this->fullmark,
            'created_at'    => $this->created_at->format('Y-m-d H:i:s'),
            "student" => [
                "first_name"    => $this->student->first_name,
                "last_name"     => $this->student->last_name,
                "email"         => $this->student->email,
                "country"       => $this->student->country,
            ],
            "formExam" => [
                'id'        => $this->formExam->id,
                'form_name' => $this->formExam->form_name,
                'type'      => $this->formExam->type,
                'formula'   => $this->formExam->formula
            ],
        ];
    }
}
