<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExamingRequest;
use App\Http\Requests\ResExamingRequest;
use App\Http\Resources\ExamingResource;
use App\Models\Examing;
use App\Models\StudentAnswer;
use Illuminate\Http\Request;

class ExamingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $studentexaming = Examing::query()
            ->orderBy('id', 'desc')
            ->simplePaginate(12);

        return ExamingResource::collection($studentexaming);
    }

    public function examingNumber()
    {
        return Examing::count();
    }

    public function examingUnCorrection()
    {
        $studentexaming = Examing::query()
            ->orderBy('id', 'desc')
            ->where('correction', 'Click To Correction')
            ->paginate(10);

        return ExamingResource::collection($studentexaming);
    }

    public function examingCorrection()
    {
        $studentexaming = Examing::query()
            ->orderBy('id', 'desc')
            ->where('correction', 'Correction')
            ->paginate(10);

        return ExamingResource::collection($studentexaming);
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
    // public function store(ExamingRequest $request)
    // {
    //     $data = $request->validated();

    //     // Save the filename in the database along with other data
    //     $examing = Examing::create([
    //         'student_id'    => $data['student_id'],
    //         'form_exams_id' => $data['form_exams_id'],
    //         'fullmark'      => $data['fullmark'],
    //     ]);

    //     // Assuming $question is the newly created Question model
    //     if (isset($data['allAnswers']) && is_array($data['allAnswers'])) {
    //         foreach ($data['allAnswers'] as $answerData) {
    //             $allAnswers = new StudentAnswer([
    //                 'stu_ans_value' => $answerData['stu_ans_value'],
    //                 'answer_id' => $answerData['answer_id'],
    //                 'answer_content' => $answerData['answer_content'],
    //             ]);
    //             // Associate the answer with the question
    //             $examing->student_answers()->save($allAnswers);
    //         }
    //     }

    //     return response("saved", 201);
    // }
    public function store(ExamingRequest $request)
    {
        $data = $request->validated();

        // Save the filename in the database along with other data
        $examing = Examing::create([
            'student_id'    => $data['student_id'],
            'form_exams_id' => $data['form_exams_id'],
            'fullmark'      => $data['fullmark'],
        ]);

        // Assuming $question is the newly created Question model
        if (isset($data['allAnswers']) && is_array($data['allAnswers'])) {
            foreach ($data['allAnswers'] as $answerData) {
                $allAnswers = new StudentAnswer([
                    'stu_ans_value' => $answerData['stu_ans_value'],
                    'answer_id' => $answerData['answer_id'],
                    'answer_content' => $answerData['answer_content'],
                ]);

                // Handle audio files
                if ($request->hasFile('allAnswers.' . $answerData['answer_id'] . '.audio_file')) {
                    $audioFile = $request->file('allAnswers.' . $answerData['answer_id'] . '.audio_file');

                    // Generate a unique filename for the audio file
                    $audioFileName = uniqid() . '_' . $audioFile->getClientOriginalName();
                    $audioPath = $audioFile->storeAs('StudentRecord', $audioFileName); // Store with a unique name
                    $allAnswers->audio_file = $audioPath;
                }

                // Associate the answer with the question
                $examing->student_answers()->save($allAnswers);
            }
        }

        return response("saved", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($examing)
    {
        $studentexaming = Examing::get()
            ->where('id', $examing);

        return ExamingResource::collection($studentexaming);
    }

    public function showScore($examing)
    {
        // Assuming you have a 'user_id' column in your 'examing' table
        $lastExaming = Examing::where('student_id', $examing)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$lastExaming) {
            // Handle the case where no exam is found for the given user
            return response()->json(['message' => 'No exam found for this user.'], 404);
        }

        return new ExamingResource($lastExaming);
    }

    public function showUserScore($student_id)
    {
        // Assuming you have a 'student_id' column in your 'examing' table
        $exams = Examing::query()->where('student_id', $student_id)->get();

        if ($exams->isEmpty()) {
            // Handle the case where no exams are found for the given user
            return response()->json(['message' => 'No exams found for this user.'], 404);
        }

        return ExamingResource::collection($exams);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Examing $examing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ResExamingRequest $request, Examing $examing)
    {
        $data = $request->validated();

        $examing->update($data);

        return response()->json(['message' => 'done'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Examing $examing)
    {
        // Delete the related answers and their associated files
        $examing->delete();

        return response()->json(['message' => 'Examing and answers deleted successfully'], 200);
    }
}
