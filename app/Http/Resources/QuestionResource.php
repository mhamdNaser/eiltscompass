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

        // Get the file contents from the public directory based on the filename
        $filePath = public_path('uploads/question/' . $this->content . '.php');

        if (file_exists($filePath)) {
            $fileContents = file_get_contents($filePath);

            return [
                'id' => $this->id,
                'type' => $this->type,
                'points' => $this->points,
                'content' => $fileContents,
                'form_exams_id' => $this->form_exams_id,
                'materials' => $this->materials->title,
                'created_at' => $this->created_at->format('Y-m-d'),
            ];
        } else {
            // Handle the case when the file does not exist
            return [
                'id' => $this->id,
                'type' => $this->type,
                'points' => $this->points,
                'content' => null,
                'material_id' => $this->material_id,
                'created_at' => $this->created_at->format('Y-m-d'),
            ];
        }
    }
}