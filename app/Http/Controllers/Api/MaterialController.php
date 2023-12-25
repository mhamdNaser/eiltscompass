<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Exam\MaterialRequest;
use App\Http\Resources\MaterialResource;
use App\Models\Material;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return MaterialResource::collection(Material::query()->orderBy('id', 'desc')->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    // public function store(MaterialRequest $request)
    // {
    // }

    public function storeMaterial(MaterialRequest $request)
    {
        // Begin the database transaction
        DB::beginTransaction();

        // Validate the request
        $data = $request->all();

        // Ensure the 'uploads/material' directory exists in the public folder
        if (!file_exists(public_path('uploads/material'))) {
            mkdir(public_path('uploads/material'), 0777, true);
        }

        $fileName = $data['title'];

        // Save the content to a file in the 'uploads/material' folder within the public folder
        file_put_contents(public_path('uploads/material/' . $fileName . '.php'), $data['content']);

        // Save the filename in the database along with other data
        $material = Material::create([
            'title'         => $data['title'],
            'form_exams_id' => $data['form_exams_id'],
        ]);

        // Commit the transaction if everything is successful
        DB::commit();

        return response()->json([
            'success' => true,
            'mes'     => 'Store Material Successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function showbyid($id)
    {
        $formExams = Material::findOrFail($id);
        return new MaterialResource($formExams);
    }

    public function showByForm($form_exams_id)
    {
        $formExams = Material::where('form_exams_id', $form_exams_id)->get();
        return MaterialResource::collection($formExams);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MaterialRequest $request, string $id)
    {
        // Begin the database transaction
        DB::beginTransaction();
        $data = $request->validated();

        // Find the material record by ID
        $material = Material::findOrFail($id);

        // Perform your modifications to the content (example: replacing old data with new data)
        $modifiedContent = $data['content'];

        // Save the modified content to the same file, overwriting the existing content
        file_put_contents(public_path('uploads/material/' . $material->title . '.php'), $modifiedContent);

        // Update other data in the database
        $material->update([
            'form_exams_id' => $data['form_exams_id'],
        ]);

        // Commit the transaction if everything is successful
        DB::commit();

        return response()->json([
            'success' => true,
            'mes' => 'Update Material Successfully',
        ]);
    }


    public function deleteMaterial($id)
    {
        // Begin the database transaction
        DB::beginTransaction();
        // Find the material record by ID
        $material = Material::findOrFail($id);

        // Delete the associated file
        $filePath = public_path('uploads/material/' . $material->title . '.php');
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete the material record from the database
        $material->delete();

        // Commit the transaction if everything is successful
        DB::commit();

        return response()->json([
            'success' => true,
            'mes' => 'Delete Material Successfully',
        ]);
    }
}