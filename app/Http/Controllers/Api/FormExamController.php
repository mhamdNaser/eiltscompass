<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActiveFormRequest;
use App\Http\Requests\FormExamMarkRequest;
use App\Http\Requests\Exam\FormExamRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\FormResource;
use App\Models\FormExam;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FormExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $searchWord = $request->input('searchWord');
        $paginateNumber = $request->input('numberParam');

        if (!$searchWord) {
            $FormExams = FormExam::query()->paginate($paginateNumber);
            return FormResource::collection($FormExams);
        }

        if (empty($searchWord)) {
            $FormExams = FormExam::query()->paginate($paginateNumber);
            return FormResource::collection($FormExams);
        } else {
            $FormExams = FormExam::where(function ($query) use ($searchWord) {
                $query->where('form_name', 'LIKE', '%' . $searchWord . '%')
                    ->orWhere('type', 'LIKE', '%' . $searchWord . '%')
                    ->orWhere('formula', 'LIKE', '%' . $searchWord . '%')
                    ->orWhere('status', 'LIKE', '%' . $searchWord . '%');
            })
                ->paginate($paginateNumber);

            return FormResource::collection($FormExams);
        }
    }

    public function AcademicReadingExam()
    {
        $randomId = FormExam::where('formula', 'academic')->where('type', 'reading')->inRandomOrder()->pluck('id')->first();

        return response()->json(['random_id' => $randomId]);
    }

    public function AcademicListeningExam()
    {
        $randomId = FormExam::where('formula', 'academic')->where('type', 'listening')->inRandomOrder()->pluck('id')->first();

        return response()->json(['random_id' => $randomId]);
    }

    public function AcademicWritingExam()
    {
        $randomId = FormExam::where('formula', 'academic')->where('type', 'writing')->inRandomOrder()->pluck('id')->first();

        return response()->json(['random_id' => $randomId]);
    }

    public function AcademicSpeakingExam()
    {
        $randomId = FormExam::where('formula', 'academic')->where('type', 'speaking')->inRandomOrder()->pluck('id')->first();

        return response()->json(['random_id' => $randomId]);
    }

    public function GeneralReadingExam()
    {
        $randomId = FormExam::where('formula', 'general')->where('type', 'reading')->inRandomOrder()->pluck('id')->first();

        return response()->json(['random_id' => $randomId]);
    }

    public function GeneralListeningExam()
    {
        $randomId = FormExam::where('formula', 'general')->where('type', 'listening')->inRandomOrder()->pluck('id')->first();

        return response()->json(['random_id' => $randomId]);
    }

    public function GeneralWritingExam()
    {
        $randomId = FormExam::where('formula', 'general')->where('type', 'writing')->inRandomOrder()->pluck('id')->first();

        return response()->json(['random_id' => $randomId]);
    }

    public function GeneralSpeakingExam()
    {
        $randomId = FormExam::where('formula', 'general')->where('type', 'speaking')->inRandomOrder()->pluck('id')->first();

        return response()->json(['random_id' => $randomId]);
    }

    public function getActiveGeneralForms()
    {
        $activeForms = FormExam::where('status', 'active')->where('formula', 'general')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return FormResource::collection($activeForms);
    }

    public function ActiveAcademyForms()
    {
        $activeForms = FormExam::where('status', 'active')->where('formula', 'academic')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return FormResource::collection($activeForms);
    }

    public function formNumber()
    {
        return FormExam::where('status', 'active')->pluck('id')->count();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormExamRequest $request)
    {
        $data = $request->validated();
        $exam = FormExam::create($data);

        return response()->json([
            'success' => true,
            'mes' => 'Store FormExam Successfully',
            'data' => $exam
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(FormExam $formExam)
    {
        return new FormResource($formExam);
    }

    public function showByName($form_name)
    {
        $formExam = FormExam::where('form_name', $form_name)->first();

        if (!$formExam) {
            return response()->json(['message' => 'Form not found'], 404);
        }

        return new FormResource($formExam);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FormExam $formExam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ActiveFormRequest $request, FormExam $formExam)
    {
        $data = $request->validated();

        $formExam->update($data);

        return new FormResource($formExam);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FormExam $formExam)
    {
        // Get the form exam ID to find related materials
        $formExamId = $formExam->id;


        // Delete the related materials and their associated files
        $relatedMaterials = Material::where('form_exams_id', $formExamId)->get();

        foreach ($relatedMaterials as $material) {
            // Delete the file associated with the material, assuming the content is the filename without extension
            $filename = $material->content;
            Storage::disk('local')->delete('material/' . $filename . '.php');

            // Delete the material from the database
            $material->delete();
        }

        // Delete the form exam
        $formExam->delete();

        return response()->json(['message' => 'Form, questions, and materials deleted successfully'], 200);
    }
}