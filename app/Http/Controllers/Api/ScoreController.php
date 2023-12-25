<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScoreRequest;
use App\Http\Resources\ScoreResource;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getGeneralReading(){
        return Score::where('Form_Formula', 'general')->where('Form_Type', 'reading')->get();
    }

    public function getAcademicReading(){
        return Score::where('Form_Formula', 'academic')->where('Form_Type', 'reading')->get();
    }

    public function getListening(){
        return Score::where('Form_Type', 'listening')->get();
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
    public function store(ScoreRequest $request)
    {
        DB::beginTransaction();
        $data = $request->all();
        $store = Score::create($data);
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
    public function show(Score $score)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Score $score)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ScoreRequest $request, Score $score)
    {
        $data = $request->validated();

        $score->update($data);

        return response()->json([
            'success' => true,
            'mes' => 'Store User Successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Score $score)
    {
        //
    }
}