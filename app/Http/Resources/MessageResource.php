<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            "user" => [
                "first_name" => $this->user->first_name,
                "last_name" => $this->user->last_name,
            ],
            'name' => $this->name,
            'email' => $this->email,
            'subject'=> $this->subject,
            "content"=> $this->content,
            'status'=> $this->status,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
