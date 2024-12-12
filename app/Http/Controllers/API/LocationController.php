<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LocationResource;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $companies = Location::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Locations retrieved successfully',
            'data' => LocationResource::collection($companies)
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
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:organic,inorganic,B3',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        if (!$validated) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validated
            ], Response::HTTP_BAD_REQUEST);
        }

        $location = Location::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Location created successfully',
            'data' => new LocationResource($location)
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
        $location = Location::find($id);

        if (!$location) {
            return response()->json([
                'status' => 'error',
                'message' => 'Location not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Location retrieved successfully',
            'data' => new LocationResource($location)
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
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:organic,inorganic,B3',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        if (!$validated) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validated
            ], Response::HTTP_BAD_REQUEST);
        }

        $location = Location::find($id);

        if (!$location) {
            return response()->json([
                'status' => 'error',
                'message' => 'Location not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $location->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Location updated successfully',
            'data' => new LocationResource($location)
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
        $location = Location::find($id);

        if (!$location) {
            return response()->json([
                'status' => 'error',
                'message' => 'Location not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $location->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Location deleted successfully'
        ], Response::HTTP_OK);
    }
}
