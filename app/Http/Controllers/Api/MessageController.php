<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\Message\MessageRequest;
use App\Http\Requests\Message\ReadingMessageRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\MessageResource;
use App\Models\message;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $searchWord = $request->input('searchWord');
        $paginateNumber = $request->input('numberParam');

        if (!$searchWord) {
            $messages = message::query()
                ->paginate($paginateNumber);
            return MessageResource::collection($messages);
        }

        if (empty($searchWord)) {
            $messages = message::query()
                ->paginate($paginateNumber);
            return MessageResource::collection($messages);
        } else {
            $messages = message::where(function ($query) use ($searchWord) {
                $query->where('name', 'LIKE', '%' . $searchWord . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchWord . '%')
                    ->orWhere('subject', 'LIKE', '%' . $searchWord . '%')
                    ->orWhere('status', 'LIKE', '%' . $searchWord . '%')
                    ->orWhere('content', 'LIKE', '%' . $searchWord . '%');
            })
                ->paginate($paginateNumber);


            return MessageResource::collection($messages);
        }
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
        DB::commit(); // Commit the transaction

        return response()->json([
            'success' => true,
            'mes' => 'Update User Successfully',
        ]);
        DB::rollBack();
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
    // public function update(ReadingMessageRequest $request, message $message)
    // {
    //     $data = $request->validated();

    //     $message->update($data);

    //     return response()->json(['message' => 'done'], 200);
    // }

    public function updateStatus(ReadingMessageRequest $request, message $message)
    {
        $data = $request->validated();

        $message->update($data);

        DB::commit(); // Commit the transaction

        return response()->json([
            'success' => true,
            'mes' => 'Update User Successfully',
        ]);
        DB::rollBack();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteMessage(DeleteRequest $request)
    {
        DB::beginTransaction(); // Begin a database transaction

        $messageId = $request->input('selectedRows');

        foreach ($messageId as $key => $value) {
            // Ensure $value is an array
            $messageIdsArray = is_array($value) ? $value : [$value];

            $messages = message::whereIn('id', $messageIdsArray)->get(); // Use get() instead of first()

            // Delete each message in the collection
            foreach ($messages as $message) {
                $message->delete();
            }
        }

        DB::commit(); // Commit the transaction

        return response()->json([
            'success' => true,
            'mes' => 'Update User Successfully',
        ]);
        DB::rollBack();
    }
}