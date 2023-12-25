<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserPaymentResource extends JsonResource
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
            "userPayment" => [
                "first_name" => $this->userPayment->first_name,
                "last_name" => $this->userPayment->last_name,
                "email" => $this->userPayment->email,
            ],
            'UsePayment_value' => $this->UsePayment_value,
            'time_expired' => $this->time_expired ? $this->time_expired->format('Y-m-d') : null,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d') : null,
        ];
    }
}
