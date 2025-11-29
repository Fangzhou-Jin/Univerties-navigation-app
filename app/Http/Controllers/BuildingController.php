<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Room;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    /**
     * Display a listing of buildings
     */
    public function index()
    {
        $buildings = Building::with(['university'])->get();
        return response()->json($buildings);
    }

    /**
     * Display the specified building
     */
    public function show($id)
    {
        $building = Building::with(['university', 'rooms'])->findOrFail($id);
        return response()->json($building);
    }

    /**
     * Store a newly created building
     */
    public function store(Request $request)
    {
        $request->validate([
            'building_code_una' => 'nullable|string|max:255',
            'building_name_una' => 'nullable|string|max:255',
            'id_university_una' => 'required|exists:universities_una,id_university_una',
        ]);

        $building = Building::create($request->all());
        return response()->json($building, 201);
    }

    /**
     * Update the specified building
     */
    public function update(Request $request, $id)
    {
        $building = Building::findOrFail($id);
        
        $request->validate([
            'building_code_una' => 'nullable|string|max:255',
            'building_name_una' => 'nullable|string|max:255',
            'id_university_una' => 'exists:universities_una,id_university_una',
        ]);

        $building->update($request->all());
        return response()->json($building);
    }

    /**
     * Remove the specified building
     */
    public function destroy($id)
    {
        $building = Building::findOrFail($id);
        $building->delete();
        return response()->json(['message' => 'Building deleted successfully']);
    }

    /**
     * Get buildings by university
     */
    public function getByUniversity($universityId)
    {
        $buildings = Building::where('id_university_una', $universityId)->get();
        return response()->json($buildings);
    }

    /**
     * Get unique floors by building
     */
    public function getFloorsByBuilding($buildingId)
    {
        $floors = Room::where('id_building_una', $buildingId)
            ->select('floor_number_una')
            ->distinct()
            ->orderBy('floor_number_una')
            ->get()
            ->pluck('floor_number_una')
            ->filter(function ($value) {
                return $value !== null;
            })
            ->map(function ($floor) {
                return [
                    'floor_number' => $floor,
                    'floor_label' => $floor == 0 ? 'Ground Floor' : 'Floor ' . $floor
                ];
            })
            ->values();

        return response()->json($floors);
    }
}

