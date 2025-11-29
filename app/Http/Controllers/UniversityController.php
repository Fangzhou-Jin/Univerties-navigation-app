<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    /**
     * Display a listing of universities
     */
    public function index()
    {
        $universities = University::all();
        return response()->json($universities);
    }

    /**
     * Display the specified university
     */
    public function show($id)
    {
        $university = University::with(['buildings', 'departments', 'rooms'])->findOrFail($id);
        return response()->json($university);
    }

    /**
     * Store a newly created university
     */
    public function store(Request $request)
    {
        $request->validate([
            'university_name_una' => 'required|string|max:255',
            'city_country' => 'required|string|max:255',
            'population' => 'required|integer',
            'post_code' => 'required|integer',
        ]);

        $university = University::create($request->all());
        return response()->json($university, 201);
    }

    /**
     * Update the specified university
     */
    public function update(Request $request, $id)
    {
        $university = University::findOrFail($id);
        
        $request->validate([
            'university_name_una' => 'string|max:255',
            'city_country' => 'string|max:255',
            'population' => 'integer',
            'post_code' => 'integer',
        ]);

        $university->update($request->all());
        return response()->json($university);
    }

    /**
     * Remove the specified university
     */
    public function destroy($id)
    {
        $university = University::findOrFail($id);
        $university->delete();
        return response()->json(['message' => 'University deleted successfully']);
    }
}

