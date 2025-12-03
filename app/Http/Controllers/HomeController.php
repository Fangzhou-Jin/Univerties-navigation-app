<?php

namespace App\Http\Controllers;

use App\Models\University;
use App\Models\Building;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Show the intro page
     */
    public function index()
    {
        return view('intro');
    }

    /**
     * Show user home page
     */
    public function userHome()
    {
        $universities = University::all();
        $buildings = Building::all();
        $rooms = Room::with(['building', 'university', 'availability', 'roomType'])->get();
        
        // Get current user
        $userId = Session::get('user_id');
        $user = $userId ? User::find($userId) : null;
        
        return view('users.home', compact('universities', 'buildings', 'rooms', 'user'));
    }

    /**
     * Show admin home page
     */
    public function adminHome()
    {
        $universities = University::all();
        $buildings = Building::all();
        $rooms = Room::with(['building', 'university', 'availability', 'roomType'])->get();
        $users = User::with('role')->get();
        
        // Get current user
        $userId = Session::get('user_id');
        $user = $userId ? User::find($userId) : null;
        
        return view('admins.home', compact('universities', 'buildings', 'rooms', 'users', 'user'));
    }

    /**
     * Show user profile
     */
    public function userProfile()
    {
        $userId = Session::get('user_id');
        $user = User::with('role')->findOrFail($userId);
        
        return view('users.profile', compact('user'));
    }

    /**
     * Show admin profile
     */
    public function adminProfile()
    {
        $userId = Session::get('user_id');
        $user = User::with('role')->findOrFail($userId);
        
        return view('admins.profile', compact('user'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $userId = Session::get('user_id');
        $user = User::findOrFail($userId);

        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users_una,email_una,' . $userId . ',id_user_una',
            'password' => 'nullable|string|min:6',
            'current_password' => 'required_with:password',
        ]);

        // If password is being changed, verify current password
        if ($request->has('password') && $request->password) {
            if (!$request->has('current_password') || !Hash::check($request->current_password, $user->password_una)) {
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Current password is incorrect.'
                    ], 422);
                }
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
        }

        $updateData = [
            'username_una' => $request->username,
            'email_una' => $request->email,
        ];

        // Update password if provided
        if ($request->has('password') && $request->password) {
            $updateData['password_una'] = Hash::make($request->password);
        }

        $user->update($updateData);

        // Update session
        Session::put('username', $user->username_una);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully.',
                'user' => $user->load('role')
            ]);
        }

        return back()->with('success', 'Profile updated successfully');
    }
}

