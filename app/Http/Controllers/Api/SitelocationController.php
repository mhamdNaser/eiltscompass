<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SiteLocationRequest;
use App\Http\Resources\SiteLocationResource;
use App\Models\Sitelocation;
use Illuminate\Http\Request;

class SitelocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return SiteLocationResource::collection(Sitelocation::query()->orderBy('id', 'desc')->paginate(10));
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
    public function store(SiteLocationRequest $request)
    {
        $data = $request->validated();
        foreach ($data as $value) {
            $sitelocation = Sitelocation::create(['content' => $value['content']]);
        }
        return response("message saved");
    }

    /**
     * Display the specified resource.
     */
    public function show(Sitelocation $sitelocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sitelocation $sitelocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sitelocation $sitelocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sitelocation $sitelocation)
    {
        $sitelocation->delete();

        return response()->json("delete done");
    }
}
