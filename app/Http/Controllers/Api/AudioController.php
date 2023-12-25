<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Audio\storeRequest;
use App\Http\Resources\AudioResource;
use App\Http\Traits\audioTrait;
use App\Models\Audio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AudioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use audioTrait;
    public function index()
    {
        return AudioResource::collection(Audio::query()->orderBy('id', 'desc')->get());

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
    public function store(storeRequest $request)
    {

        DB::beginTransaction();
        $data = $request->all();
        $data['audio'] = $this->saveAudio($request->audio, 'uploads/audio/gallery/'); // Update with your actual method for saving audio

        $store = Audio::create($data);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Audio stored successfully',
            'data' => $data["audio"],
        ]);
    }



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
    public function destroy($audio)
    {
        $myAudio = Audio::find($audio);

        // التحقق من وجود الكائن
        if (!$myAudio) {
            return response()->json([
                'success' => false,
                'mes' => 'Image not found',
            ]);
        }

        $filePath = 'uploads/audio/gallery/' . $myAudio->audio;
        $fullPath = public_path($filePath);

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }

        $myAudio->delete();

        return response()->json([
            'success' => true,
            'mes' => 'Delete Image Permanently',
        ]);
    }
}