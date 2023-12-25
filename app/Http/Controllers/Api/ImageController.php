<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ImageResource::collection(Image::query()->orderBy('id', 'desc')->paginate(10));
    }

    public function gallery()
    {
        return  ImageResource::collection(Image::query()->orderBy('id', 'desc')->paginate(10));
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
            'file' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $data = []; // Initialize the data array

        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $filename);
            // Assuming 'filename' is a valid field in your MaterialImage model
            $data['name'] = $filename;
        }

        $material = Image::create($data);

        return new ImageResource($material);
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
    public function destroy(Image $image)
    {
        // Delete the image file from storage
        Storage::delete('public/images/' . $image->name);

        // Delete the material image record from the database
        $image->delete();

        return response()->json("");
    }
}
