<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScoreResource extends JsonResource
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
            'Form_Formula' => $this->Form_Formula,
            'Form_Type' => $this->Form_Type,
            'Score' => $this->Score,
            'min' => $this->min,
            'max' => $this->max,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
