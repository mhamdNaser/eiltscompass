<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MaterialImg;
use App\Http\Resources\MateialImageResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialImgController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return MateialImageResource::collection(MaterialImg::query()->orderBy('id', 'desc')->paginate(10));
    }

    public function gallery()
    {
        return  MateialImageResource::collection(MaterialImg::query()->orderBy('id', 'desc')->paginate(10));
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
            $image->storeAs('public/imagesMaterial', $filename);
            // Assuming 'filename' is a valid field in your MaterialImage model
            $data['name'] = $filename;
        }

        $material = MaterialImg::create($data);

        return new MateialImageResource($material);
    }

    /**
     * Display the specified resource.
     */
    public function show(MaterialImg $materialImg)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaterialImg $materialImg)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaterialImg $materialImg)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaterialImg $materialImg)
    {
            // Delete the image file from storage
            Storage::delete('public/imagesMaterial/' . $materialImg->name);

            // Delete the material image record from the database
            $materialImg->delete();

            return response()->json("");
    }
}
