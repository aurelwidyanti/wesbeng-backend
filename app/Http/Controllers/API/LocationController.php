<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // GET: /api/locations
    public function index()
    {
        return response()->json(Location::all(), 200);
    }

    // POST: /api/locations
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $location = Location::create($validated);
        return response()->json($location, 201);
    }

    // GET: /api/locations/{id}
    public function show($id)
    {
        $location = Location::find($id);
        if ($location) {
            return response()->json($location, 200);
        } else {
            return response()->json(['message' => 'Location not found'], 404);
        }
    }

    // PUT: /api/locations/{id}
    public function update(Request $request, $id)
    {
        $location = Location::find($id);
        if (!$location) {
            return response()->json(['message' => 'Location not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $location->update($validated);
        return response()->json($location, 200);
    }

    // DELETE: /api/locations/{id}
    public function destroy($id)
    {
        $location = Location::find($id);
        if ($location) {
            $location->delete();
            return response()->json(['message' => 'Location deleted'], 200);
        } else {
            return response()->json(['message' => 'Location not found'], 404);
        }
    }
}
