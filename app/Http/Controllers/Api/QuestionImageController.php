<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionImageResource;
use App\Models\QuestionImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuestionImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return QuestionImageResource::collection(QuestionImage::query()->orderBy('id', 'desc')->paginate(10));
    }

    public function gallery()
    {
        return  QuestionImageResource::collection(QuestionImage::query()->orderBy('id', 'desc')->paginate(10));
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
            $image->storeAs('public/imagesQuestion', $filename);
            // Assuming 'filename' is a valid field in your MaterialImage model
            $data['name'] = $filename;
        }

        $material = QuestionImage::create($data);

        return new QuestionImageResource($material);
    }

    /**
     * Display the specified resource.
     */
    public function show(QuestionImage $questionImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuestionImage $questionImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuestionImage $questionImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuestionImage $questionImage)
    {
        // Delete the image file from storage
        Storage::delete('public/imagesQuestion/' . $questionImage->name);

        // Delete the material image record from the database
        $questionImage->delete();

        return response()->json("");
    }
}
