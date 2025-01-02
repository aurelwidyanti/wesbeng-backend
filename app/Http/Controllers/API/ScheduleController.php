<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $schedules = Schedule::with('location')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Schedules retrieved successfully',
            'data' => ScheduleResource::collection($schedules)
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
            'location_id' => 'required|exists:locations,id',
            'date' => 'required|date',
        ]);

        if (!$validated) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validated
            ], 400);
        }

        $schedule = Schedule::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Schedule created successfully',
            'data' => new ScheduleResource($schedule)
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
        $schedule = Schedule::find($id);

        if (!$schedule) {
            return response()->json([
                'status' => 'error',
                'message' => 'Schedule not found'
            ], 404);
        }

        $schedule->load('location');

        return response()->json([
            'status' => 'success',
            'message' => 'Schedule retrieved successfully',
            'data' => new ScheduleResource($schedule)
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
            'location_id' => 'required|exists:locations,id',
            'date' => 'required|date',
        ]);

        if (!$validated) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validated
            ], 400);
        }

        $schedule = Schedule::find($id);

        if (!$schedule) {
            return response()->json([
                'status' => 'error',
                'message' => 'Schedule not found'
            ], 404);
        }

        $schedule->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Schedule updated successfully',
            'data' => new ScheduleResource($schedule)
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
        $schedule = Schedule::find($id);

        if (!$schedule) {
            return response()->json([
                'status' => 'error',
                'message' => 'Schedule not found'
            ], 404);
        }

        $schedule->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Schedule deleted successfully'
        ], 200);
    }
}
