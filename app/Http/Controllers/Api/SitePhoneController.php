<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SitePhoneRequest;
use App\Http\Resources\SitePhoneResource;
use App\Models\SitePhone;
use Illuminate\Http\Request;

class SitePhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return SitePhoneResource::collection(SitePhone::query()->orderBy('id', 'desc')->paginate(10));
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
    public function store(SitePhoneRequest $request)
    {
        $data = $request->validated();
        foreach ($data as $value) {
            $sitePhone = SitePhone::create(['content' => $value['content']]);
        }
        return response("message saved");
    }


    /**
     * Display the specified resource.
     */
    public function show(SitePhone $sitePhone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SitePhone $sitePhone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SitePhone $sitePhone)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SitePhone $sitePhone)
    {
        $sitePhone->delete();

        return response()->json("delete done");
    }
}
