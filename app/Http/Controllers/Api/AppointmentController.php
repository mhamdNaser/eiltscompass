<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentRequest;
use App\Http\Requests\AppointmentStateRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AppointmentResource::collection(Appointment::query()->orderBy('id', 'desc')->paginate(10));
    }

    public function Appointmentpending()
    {
        return AppointmentResource::collection(Appointment::query()->orderBy('id', 'desc')->where('status', 'Pending')->paginate(10));
    }

    public function Appointmentactive()
    {
        return AppointmentResource::collection(Appointment::query()->where('status', 'Approval')->orderBy('id', 'desc')->paginate(10));
    }

    public function Appointmentdone()
    {
        return AppointmentResource::collection(Appointment::query()->where('status', 'Done')->orderBy('id', 'desc')->paginate(10));
    }

    public function AppointmentInToday()
    {
        $currentDate = now()->format('Y-m-d'); // Get the current date in 'Y-m-d' format
        return AppointmentResource::collection(
            Appointment::query()
                ->where('status', 'Approval')
                ->whereDate('start_time', $currentDate) // Filter by the current date
                ->orderBy('id', 'desc')
                ->paginate(10)
        );
    }

    public function Appointmentdelete()
    {
        return AppointmentResource::collection(Appointment::query()->orderBy('id', 'desc')->where('status', 'Delete')->paginate(10));
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
    public function store(AppointmentRequest $request)
    {
        $data = $request->validated();
        $appointment = Appointment::create($data);

        return new $appointment;
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AppointmentStateRequest $request, Appointment $appointment)
    {
        //
    }

    public function activeAppoint(AppointmentStateRequest $request, Appointment $appointment)
    {
        $data = $request->validated();

        $appointment->update($data);

        return new AppointmentResource($appointment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        // Delete the material image record from the database
        $appointment->delete();

        return response()->json("delete done");
    }
}
