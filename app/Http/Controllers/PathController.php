<?php

namespace App\Http\Controllers;

use App\Models\Path;
use Illuminate\Http\Request;

class PathController extends Controller
{
    /**
     * Display a listing of paths
     */
    public function index()
    {
        $paths = Path::with(['roomA', 'roomB'])->get();
        return response()->json($paths);
    }

    /**
     * Display the specified path
     */
    public function show($id)
    {
        $path = Path::with(['roomA', 'roomB'])->findOrFail($id);
        return response()->json($path);
    }

    /**
     * Store a newly created path
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_room_point_a_una' => 'required|exists:rooms_una,id_room_una',
            'id_room_point_b_una' => 'required|exists:rooms_una,id_room_una',
            'walking_distance_meters' => 'required|integer',
            'estimated_time_minutes' => 'required|integer',
        ]);

        $path = Path::create($request->all());
        return response()->json($path, 201);
    }

    /**
     * Update the specified path
     */
    public function update(Request $request, $id)
    {
        $path = Path::findOrFail($id);
        
        $request->validate([
            'id_room_point_a_una' => 'exists:rooms_una,id_room_una',
            'id_room_point_b_una' => 'exists:rooms_una,id_room_una',
            'walking_distance_meters' => 'integer',
            'estimated_time_minutes' => 'integer',
        ]);

        $path->update($request->all());
        return response()->json($path);
    }

    /**
     * Remove the specified path
     */
    public function destroy($id)
    {
        $path = Path::findOrFail($id);
        $path->delete();
        return response()->json(['message' => 'Path deleted successfully']);
    }

    /**
     * Find path between two rooms
     */
    public function findPath($roomAId, $roomBId)
    {
        $path = Path::where('id_room_point_a_una', $roomAId)
            ->where('id_room_point_b_una', $roomBId)
            ->orWhere(function($query) use ($roomAId, $roomBId) {
                $query->where('id_room_point_a_una', $roomBId)
                      ->where('id_room_point_b_una', $roomAId);
            })
            ->with(['roomA', 'roomB'])
            ->first();

        if (!$path) {
            return response()->json(['message' => 'No path found between these rooms'], 404);
        }

        return response()->json($path);
    }
}

