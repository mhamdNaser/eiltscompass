<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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

        // Get the file contents from the public directory based on the filename
        $filePath = public_path('uploads/material/' . $this->title . '.php');

        if (file_exists($filePath)) {
            $fileContents = file_get_contents($filePath);

            return [
                'id' => $this->id,
                'title' => $this->title,
                'content' => $fileContents,
                'form_exams_id' => $this->form_exams_id,
                'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            ];
        } else {
            // Handle the case when the file does not exist
            return [
                'id' => $this->id,
                'content' => null, // or handle it in a way that fits your application logic
                'form_exams_id' => $this->form_exams_id,
                'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            ];
        }
    }
}