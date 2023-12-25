<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Video\storeRequest;
use App\Http\Resources\VideoResource;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Http\Traits\VideoTrait;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use VideoTrait;
    public function index()
    {
        return VideoResource::collection(Video::query()->orderBy('id', 'desc')->get());
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
        $data['video'] = $this->saveVideo($request->video, 'uploads/video/gallery/'); // Update with your actual method for saving audio

        $store = Video::create($data);

        DB::commit();
        return response()->json([
            'success' => true,
            'message' => 'Video stored successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($video)
    {
        $myVideo = Video::find($video);

        // التحقق من وجود الكائن
        if (!$myVideo) {
            return response()->json([
                'success' => false,
                'mes' => 'Image not found',
            ]);
        }

        $filePath = 'uploads/video/gallery/' . $myVideo->video;
        $fullPath = public_path($filePath);

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }

        $myVideo->delete();

        return response()->json([
            'success' => true,
            'mes' => 'Delete Image Permanently',
        ]);
    }
}