<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentRequest;
use App\Http\Requests\Payment\UpdatePaymentRequest;
use App\Models\PaymentMethods;
use Illuminate\Support\Facades\DB;

class PaymentMethodsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PaymentMethods::all();
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
    public function store(PaymentRequest $request)
    {
        DB::beginTransaction();
        $data = $request->all();
        $payment = PaymentMethods::create($data);
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
    public function show(PaymentMethods $paymentMethods)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethods $paymentMethods)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, $paymentMethods)
    {
        DB::beginTransaction();
        $user = PaymentMethods::find($paymentMethods);
        $data = $request->all();
        $user->update([
            'name'          => $request->name ?? $user->name,
            'clientId'      => $request->clientId ?? $user->clientId,
            'secret'        => $request->secret ?? $user->secret,
            'MonSub'        => $request->MonSub ?? $user->MonSub,
        ]);
        DB::commit();
        return response()->json([
            'success' => true,
            'mes' => 'Update User Successfully',
        ]);
        DB::rollBack();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethods $paymentMethods)
    {
        //
    }
}
