<?php

namespace App\Http\Traits;

trait FileTrait
{
    /**
     * Save a file to the specified folder.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @return string
     */
    public function saveFile($file, $folder)
    {
        // Generate a random string using uniqid
        $randomString = uniqid();

        // Combine the random string and an empty file extension to create a unique filename
        $fileName = $randomString;
        $path = $folder;

        // Move the file to the specified folder with the generated file name
        $file->move($path, $fileName);

        return $fileName;
    }
}