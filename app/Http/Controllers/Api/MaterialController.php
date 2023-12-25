<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaterialRequest;
use App\Http\Resources\MaterialResource;
use App\Models\Material;
use Illuminate\Http\Request;
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


    public function store(MaterialRequest $request)
    {
        $data = $request->validated();

        // Generate a unique filename for the content
        $filename = $this->generateUniqueFileName();

        // Save the content to a file in the 'material' folder
        Storage::disk('local')->put('material/' . $filename . '.php', $data['content']);

        // Save the filename in the database along with other data
        $material = Material::create([
            'content' => $filename,
            'form_exams_id' => $data['form_exams_id'],
        ]);

        return response(new MaterialResource($material), 201);
    }

    private function generateUniqueFileName()
    {
        return uniqid('content_', true); // Generates a unique filename with a prefix 'content_'
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MaterialRequest $request, string $id)
    {
        $data = $request->validated();

        // Find the material record by ID
        $material = Material::findOrFail($id);

        // Perform your modifications to the content (example: replacing old data with new data)
        $modifiedContent = $data['content'];

        // Save the modified content to the same file, overwriting the existing content
        Storage::disk('local')->put('material/' . $material->content . '.php', $modifiedContent);

        // Update other data in the database if needed
        $material->update([
            'id' => $data['id'],
            'form_exams_id' => $data['form_exams_id'],
        ]);

        return response(json_decode("true"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}