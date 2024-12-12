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
        $educationContents = EducationContent::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Education Contents retrieved successfully',
            'data' => EducationContentResource::collection($educationContents)
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

        if (!$validated) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validated
            ], Response::HTTP_BAD_REQUEST);
        }

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
            ], Response::HTTP_NOT_FOUND);
        }
        
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
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|string',
            'category' => 'required|in:organic,inorganic,B3'
        ]);

        if (!$validated) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validated
            ], Response::HTTP_BAD_REQUEST);
        }

        $educationContent = EducationContent::find($id);

        if (!$educationContent) {
            return response()->json([
                'status' => 'error',
                'message' => 'Education Content not found'
            ], Response::HTTP_NOT_FOUND);
        }

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
            ], Response::HTTP_NOT_FOUND);
        }

        $educationContent->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Education Content deleted successfully'
        ], Response::HTTP_OK);
    }
}
