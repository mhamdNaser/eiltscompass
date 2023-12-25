<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Image\storeRequest;
use App\Http\Resources\ImageResource;
use App\Http\Traits\imageTrait;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use imageTrait;
    public function index()
    {
        return ImageResource::collection(Image::query()->orderBy('id', 'desc')->get());
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
        $data['image'] = $this->saveImage($request->image, 'uploads/images/gallery');
        $store = Image::create($data);
        DB::commit();
        return response()->json([
            'success' => true,
            'mes' => 'Store User Successfully',
        ]);
        DB::rollBack();
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($image)
    {
        $myImage = Image::find($image);

        // التحقق من وجود الكائن
        if (!$myImage) {
            return response()->json([
                'success' => false,
                'mes' => 'Image not found',
            ]);
        }

        $filePath = 'uploads/images/gallery/' . $myImage->image;
        $fullPath = public_path($filePath);

        // التحقق من وجود الملف قبل حذفه
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }

        // حذف السجل من قاعدة البيانات
        $myImage->delete();

        return response()->json([
            'success' => true,
            'mes' => 'Delete Image Permanently',
        ]);

    }

}