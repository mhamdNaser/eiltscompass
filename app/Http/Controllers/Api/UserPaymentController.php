<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPaymentRequest;
use App\Http\Resources\UserPaymentResource;
use App\Models\UserPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userPayments = UserPayment::query()
            ->orderBy('time_expired', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return UserPaymentResource::collection($userPayments);
    }

    public function userPaymentNumber()
    {
        $sum = UserPayment::sum('usePayment_value');
        return $sum;
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
    public function store(UserPaymentRequest $request)
    {
        $data = $request->validated();

        // Calculate the expiration time (one month from now)
        $timeExpired = Carbon::now()->addMonth();

        // Add the calculated expiration time to the data array
        $data['time_expired'] = $timeExpired;

        $userPayment = UserPayment::create($data);

        return response(new UserPaymentResource($userPayment), 201);
    }


    public function tryStore(UserPaymentRequest $request)
    {
        $data = $request->validated();

        // Calculate the expiration time (three days from now)
        $timeExpired = Carbon::now()->addDays(3);

        // Add the calculated expiration time to the data array
        $data['time_expired'] = $timeExpired;

        $userPayment = UserPayment::create($data);

        return response(new UserPaymentResource($userPayment), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserPayment $userPayment)
    {
        //
    }

    public function showByUser($user_id)
    {
        $userPayment = UserPayment::where('UsePayment_id', $user_id)->first();

        if (!$userPayment) {
            return response()->json(['message' => 'Materials not found'], 404);
        }

        return new UserPaymentResource($userPayment);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserPayment $userPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserPayment $userPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserPayment $userPayment)
    {
        try {
            $userPayment->delete();
            return response()->json(['message' => 'userPayment Delete Successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting userPayment'], 500);
        }
    }
}
