<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index()
    {
        $users = User::with('role')->get();
        return response()->json($users);
    }

    /**
     * Display the specified user
     */
    public function show($id)
    {
        $user = User::with('role')->findOrFail($id);
        return response()->json($user);
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $request->validate([
            'username_una' => 'required|string|max:255',
            'email_una' => 'required|email|unique:users_una,email_una',
            'password_una' => 'required|string|min:6',
            'id_role_una' => 'required|exists:roles_una,id_role_una',
        ]);

        $user = User::create([
            'username_una' => $request->username_una,
            'email_una' => $request->email_una,
            'password_una' => Hash::make($request->password_una),
            'id_role_una' => $request->id_role_una,
            'google_auth_una' => null,
        ]);

        return response()->json($user->load('role'), 201);
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'username_una' => 'string|max:255',
            'email_una' => 'email|unique:users_una,email_una,' . $id . ',id_user_una',
            'id_role_una' => 'exists:roles_una,id_role_una',
        ]);

        $updateData = [];
        
        if ($request->has('username_una')) {
            $updateData['username_una'] = $request->username_una;
        }
        
        if ($request->has('email_una')) {
            $updateData['email_una'] = $request->email_una;
        }
        
        if ($request->has('password_una') && $request->password_una) {
            $updateData['password_una'] = Hash::make($request->password_una);
        }
        
        if ($request->has('id_role_una')) {
            $updateData['id_role_una'] = $request->id_role_una;
        }

        $user->update($updateData);
        
        return response()->json($user->load('role'));
    }

    /**
     * Remove the specified user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    /**
     * Get all roles
     */
    public function getRoles()
    {
        $roles = Role::all();
        return response()->json($roles);
    }
}

