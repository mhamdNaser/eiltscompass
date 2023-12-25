<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaypalRequest;
use App\Http\Resources\PaypalResource;
use App\Models\Paypal;
use Illuminate\Http\Request;

class PaypalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PaypalResource::collection(Paypal::first()->orderBy('id', 'desc')->paginate(10));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Paypal $paypal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paypal $paypal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaypalRequest $request, Paypal $paypal)
    {
        $data = $request->validated();

        $paypal->update($data);

        return response()->json(['message' => 'done'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paypal $paypal)
    {
        //
    }
}
