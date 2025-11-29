<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of departments
     */
    public function index()
    {
        $departments = Department::with(['university'])->get();
        return response()->json($departments);
    }

    /**
     * Display the specified department
     */
    public function show($id)
    {
        $department = Department::with(['university'])->findOrFail($id);
        return response()->json($department);
    }

    /**
     * Store a newly created department
     */
    public function store(Request $request)
    {
        $request->validate([
            'department_name_una' => 'required|string|max:255',
            'id_university_una' => 'required|exists:universities_una,id_university_una',
        ]);

        $department = Department::create($request->all());
        return response()->json($department, 201);
    }

    /**
     * Update the specified department
     */
    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);
        
        $request->validate([
            'department_name_una' => 'string|max:255',
            'id_university_una' => 'exists:universities_una,id_university_una',
        ]);

        $department->update($request->all());
        return response()->json($department);
    }

    /**
     * Remove the specified department
     */
    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return response()->json(['message' => 'Department deleted successfully']);
    }

    /**
     * Get departments by university
     */
    public function getByUniversity($universityId)
    {
        $departments = Department::where('id_university_una', $universityId)->get();
        return response()->json($departments);
    }
}

