<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use App\Http\Requests\Exam\QuestionRequest;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(QuestionRequest $request)
    {
        // Begin the database transaction
        DB::beginTransaction();

        // Validate the request
        $data = $request->all();

        // Generate a unique filename for the content
        $filename = $this->generateUniqueFileName();

        // Ensure the 'uploads/material' directory exists in the public folder
        if (!file_exists(public_path('uploads/question'))) {
            mkdir(public_path('uploads/question'), 0777, true);
        }

        // Save the content to a file in the 'uploads/material' folder within the public folder
        file_put_contents(public_path('uploads/question/' . $filename . '.php'), $data['content']);

        // Save the filename in the database along with other data
        $question = Question::create([
            'content'       => $filename,
            'type'          => $data['type'],
            'points'        => $data['points'],
            'material_id'   => $data['material_id'],
            'form_exams_id' => $data['form_exams_id'],
        ]);

        // Assuming $question is the newly created Question model
        if (isset($data['answer']) && is_array($data['answer'])) {
            foreach ($data['answer'] as $answerData) {
                $answer = new Answer([
                    'answer_content' => $answerData['answer_content'],
                    'answer_value' => $answerData['answer_value'],
                ]);
                // Associate the answer with the question
                $question->answers()->save($answer);
            }
        }

        // Commit the transaction if everything is successful
        DB::commit();

        return response()->json([
            'success' => true,
            'mes'     => 'Store Material Successfully',
        ]);
    }

    private function generateUniqueFileName()
    {
        return uniqid('content_', true); // Generates a unique filename with a prefix 'content_'
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    public function showByForm($form_exams_id)
    {
        $formExams = Question::where('form_exams_id', $form_exams_id)->get();
        return QuestionResource::collection($formExams);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        // Get the question ID to find related answers
        $questionId = $question->id;
        $contentFileName = $question->content;

        // Check if the content file exists and then delete it
        Storage::disk('local')->delete('question/' . $contentFileName . '.php');

        // Delete the related answers and their associated files
        Answer::where('question_id', $questionId)->delete();

        // Delete the question
        $question->delete();

        return response()->json(['message' => 'Question and answers deleted successfully'], 200);
    }
}
