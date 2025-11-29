<?php

namespace App\Http\Controllers;

use App\Models\University;
use App\Models\Building;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
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
        
        return view('users.home', compact('universities', 'buildings', 'rooms'));
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
        
        return view('admins.home', compact('universities', 'buildings', 'rooms', 'users'));
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
        ]);

        $user->update([
            'username_una' => $request->username,
            'email_una' => $request->email,
        ]);

        // Update session
        Session::put('username', $user->username_una);

        return back()->with('success', 'Profile updated successfully');
    }
}

