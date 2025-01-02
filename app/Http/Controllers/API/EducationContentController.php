<?php

namespace App\Http\Controllers\API;

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
        $educationContents = EducationContent::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Education Contents retrieved successfully',
            'data' => EducationContentResource::collection($educationContents)
        ], 200);
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
            'category' => 'required|in:organic,anorganic,B3'
        ]);

        if (!$validated) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validated
            ], 400);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('education-contents');
        }

        $educationContent = EducationContent::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Education Content created successfully',
            'data' => new EducationContentResource($educationContent)
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $educationContent = EducationContent::find($id);

        if (!$educationContent) {
            return response()->json([
                'status' => 'error',
                'message' => 'Education Content not found'
            ], 404);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => 'Education Content retrieved successfully',
            'data' => new EducationContentResource($educationContent)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|string',
            'category' => 'required|in:organic,anorganic,B3'
        ]);

        if (!$validated) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validated
            ], 400);
        }

        $educationContent = EducationContent::find($id);

        if (!$educationContent) {
            return response()->json([
                'status' => 'error',
                'message' => 'Education Content not found'
            ], 404);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('education-contents');
        }

        $educationContent->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Education Content updated successfully',
            'data' => new EducationContentResource($educationContent)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $educationContent = EducationContent::find($id);

        if (!$educationContent) {
            return response()->json([
                'status' => 'error',
                'message' => 'Education Content not found'
            ], 404);
        }

        $educationContent->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Education Content deleted successfully'
        ], 200);
    }
}
