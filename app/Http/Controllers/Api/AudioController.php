<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AudioResource;
use App\Models\Audio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AudioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AudioResource::collection(Audio::query()->orderBy('id', 'desc')->paginate(10));
    }

    public function gallery()
    {
        return  AudioResource::collection(Audio::query()->orderBy('id', 'desc')->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:mpeg,wav,x-wav,ogg,mp3',
        ]);

        if ($request->hasFile('file')) {
            $thisaudio = $request->file('file');

            // Get the original filename
            $originalFilename = $thisaudio->getClientOriginalName();

            // Store the audio file with the original name
            $thisaudio->storeAs('public/audio', $originalFilename);
        }

        // Create a new audio record in the database
        $audio = Audio::create([
            'original_name' => $originalFilename,
            'name' => $originalFilename, // You can use the same name for simplicity
        ]);
        return new AudioResource($audio);
    }
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|file|mimes:mpeg,wav,x-wav,ogg,mp3',
    //     ]);

    //     $data = []; // Initialize the data array

    //     if ($request->hasFile('file')) {
    //         $thisaudio = $request->file('file');
    //         $filename = uniqid() . '.' . $thisaudio->getClientOriginalExtension();
    //         $thisaudio->storeAs('public/audio', $filename);
    //         // Assuming 'filename' is a valid field in your MaterialImage model
    //         $data['name'] = $filename;
    //     }

    //     $audio = Audio::create($data);

    //     return response()->json("done", $audio);
    // }

    /**
     * Display the specified resource.
     */
    public function show(Audio $audio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Audio $audio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Audio $audio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Audio $audio)
    {
        // Delete the image file from storage
        Storage::delete('public/audio/' . $audio->name);

        // Delete the material image record from the database
        $audio->delete();

        return response()->json("");
    }
}
