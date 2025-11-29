<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of rooms
     */
    public function index()
    {
        $rooms = Room::with(['university', 'building', 'availability', 'roomType'])->get();
        return response()->json($rooms);
    }

    /**
     * Display the specified room
     */
    public function show($id)
    {
        $room = Room::with(['university', 'building', 'availability', 'roomType'])->findOrFail($id);
        return response()->json($room);
    }

    /**
     * Store a newly created room
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_number_una' => 'required|string|max:255',
            'room_name_una' => 'nullable|string|max:255',
            'floor_number_una' => 'nullable|integer',
            'id_university_una' => 'required|exists:universities_una,id_university_una',
            'id_availability_una' => 'required|exists:availability_una,id_availability_una',
            'id_room_type_una' => 'required|exists:room_types_una,id_room_type_una',
            'id_building_una' => 'required|exists:buildings_una,id_building_una',
        ]);

        $room = Room::create($request->all());
        return response()->json($room, 201);
    }

    /**
     * Update the specified room
     */
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        
        $request->validate([
            'room_number_una' => 'string|max:255',
            'room_name_una' => 'nullable|string|max:255',
            'floor_number_una' => 'nullable|integer',
            'id_university_una' => 'exists:universities_una,id_university_una',
            'id_availability_una' => 'exists:availability_una,id_availability_una',
            'id_room_type_una' => 'exists:room_types_una,id_room_type_una',
            'id_building_una' => 'exists:buildings_una,id_building_una',
        ]);

        $room->update($request->all());
        return response()->json($room);
    }

    /**
     * Remove the specified room
     */
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return response()->json(['message' => 'Room deleted successfully']);
    }

    /**
     * Search rooms
     */
    public function search(Request $request)
    {
        $query = Room::with(['university', 'building', 'availability', 'roomType']);

        if ($request->has('university_id')) {
            $query->where('id_university_una', $request->university_id);
        }

        if ($request->has('building_id')) {
            $query->where('id_building_una', $request->building_id);
        }

        if ($request->has('floor_number')) {
            $query->where('floor_number_una', $request->floor_number);
        }

        if ($request->has('room_type_id')) {
            $query->where('id_room_type_una', $request->room_type_id);
        }

        if ($request->has('availability_id')) {
            $query->where('id_availability_una', $request->availability_id);
        }

        if ($request->has('room_number')) {
            $query->where('room_number_una', 'like', '%' . $request->room_number . '%');
        }

        if ($request->has('search_query')) {
            $searchQuery = $request->search_query;
            $query->where(function($q) use ($searchQuery) {
                $q->where('room_number_una', 'like', '%' . $searchQuery . '%')
                  ->orWhere('room_name_una', 'like', '%' . $searchQuery . '%');
            });
        }

        $rooms = $query->get();
        return response()->json($rooms);
    }

    /**
     * Get all room types
     */
    public function getRoomTypes()
    {
        $roomTypes = \App\Models\RoomType::all();
        return response()->json($roomTypes);
    }

    /**
     * Get all availability statuses
     */
    public function getAvailability()
    {
        $availability = \App\Models\Availability::all();
        return response()->json($availability);
    }
}

