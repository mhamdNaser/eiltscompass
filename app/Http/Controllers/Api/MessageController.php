<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Http\Requests\ReadingMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return MessageResource::collection(message::query()->orderBy('id', 'desc')->paginate(10));
    }

    public function messagePending()
    {
        return MessageResource::collection(message::query()->where('status', 'Pending')->orderBy('id', 'desc')->paginate(10));
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
    public function store(MessageRequest $request)
    {
        $data = $request->validated();
        $message = message::create($data);

        return new MessageResource($message);
    }

    /**
     * Display the specified resource.
     */
    public function show(message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReadingMessageRequest $request, message $message)
    {
        $data = $request->validated();

        $message->update($data);

        return response()->json(['message' => 'done'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(message $message)
    {
        // Delete the material image record from the database
        $message->delete();

        return response()->json("delete done");
    }
}
