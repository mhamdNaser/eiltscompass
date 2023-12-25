<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SiteEmailRequest;
use App\Http\Resources\SiteEmailResource;
use App\Models\Sitemail;
use Illuminate\Http\Request;

class SitemailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return SiteEmailResource::collection(Sitemail::query()->orderBy('id', 'desc')->paginate(10));
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
    public function store(SiteEmailRequest $request)
    {
        $data = $request->validated();
        foreach ($data as $value) {
            $siteemail = Sitemail::create(['content' => $value['content']]);
        }
        return response("message saved");
    }

    /**
     * Display the specified resource.
     */
    public function show(Sitemail $sitemail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sitemail $sitemail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sitemail $sitemail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sitemail $sitemail)
    {
        $sitemail->delete();

        return response()->json("delete done");
    }
}
