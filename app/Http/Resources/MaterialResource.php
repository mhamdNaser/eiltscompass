<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MaterialResource extends JsonResource
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
        $fileContents = Storage::disk('local')->get('material/' . $this->content . '.php');

        return [
            'id' => $this->id,
            'content' => $fileContents,
            'form_exams_id' => $this->form_exams_id,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
