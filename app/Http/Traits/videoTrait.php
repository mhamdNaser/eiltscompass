<?php

namespace App\Http\Traits;

trait VideoTrait
{
    /**
     * Save a video file to the specified folder.
     *
     * @param \Illuminate\Http\UploadedFile $video
     * @param string $folder
     * @return string|null
     */
    public function saveVideo($video, $folder)
    {
        if ($video->isValid() && $video->getMimeType() && strpos($video->getMimeType(), 'video/') === 0) {
            $fileExtension = $video->getClientOriginalExtension();
            $fileName = time() . '.' . $fileExtension;
            $path = $folder;

            // Move the video file to the specified folder
            $video->move($path, $fileName);

            return $fileName;
        }

        return null;
    }
}