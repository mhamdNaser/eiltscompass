<?php

namespace App\Http\Traits;

trait audioTrait
{
    /**
     * Save an audio file to the specified folder.
     *
     * @param \Illuminate\Http\UploadedFile $audio
     * @param string $folder
     * @return string|null
     */
    public function saveAudio($audio, $folder)
    {
        if ($audio->isValid()) {
            $fileExtension = $audio->getClientOriginalExtension();
            $fileName = time() . '.' . $fileExtension;
            $path = $folder;

            // Move the audio file to the specified folder
            $audio->move($path, $fileName);

            return $fileName;
        }

        return null;
    }
}