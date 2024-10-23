<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EducationContentResource;
use App\Models\EducationContent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EducationContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $companies = EducationContent::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Education Contents retrieved successfully',
            'data' => EducationContentResource::collection($companies)
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|string',
            'category' => 'required|in:organic,inorganic,B3'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('education-contents');
        }

        $educationContent = EducationContent::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Education Content created successfully',
            'data' => new EducationContentResource($educationContent)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EducationContent  $educationContent
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(EducationContent $educationContent)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Education Content retrieved successfully',
            'data' => new EducationContentResource($educationContent)
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EducationContent  $educationContent
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, EducationContent $educationContent)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|string',
            'category' => 'required|in:organic,inorganic,B3'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('education-contents');
        }

        $educationContent->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Education Content updated successfully',
            'data' => new EducationContentResource($educationContent)
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EducationContent  $educationContent
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(EducationContent $educationContent)
    {
        $educationContent->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Education Content deleted successfully'
        ], Response::HTTP_OK);
    }
}
