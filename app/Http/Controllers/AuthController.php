<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Services\GoogleAuthenticatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLogin()
    {
        return view('users.login');
    }

    /**
     * Show the register form
     */
    public function showRegister()
    {
        return view('users.register');
    }

    /**
     * Handle user login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email_una', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password_una)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput();
        }

        // Store user info in session
        Session::put('user_id', $user->id_user_una);
        Session::put('user_role', $user->id_role_una);
        Session::put('username', $user->username_una);

        // Redirect based on role
        if ($user->id_role_una == 2) { // Admin
            return redirect()->route('admin.home');
        }

        return redirect()->route('user.home');
    }

    /**
     * Handle user registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users_una,email_una',
            'password' => 'required|min:6|confirmed',
        ]);

        // Get User role (id = 1)
        $userRole = Role::where('role_name_una', 'User')->first();

        $user = User::create([
            'username_una' => $request->username,
            'email_una' => $request->email,
            'password_una' => Hash::make($request->password),
            'id_role_una' => $userRole->id_role_una ?? 1,
        ]);

        // Auto login after registration
        Session::put('user_id', $user->id_user_una);
        Session::put('user_role', $user->id_role_una);
        Session::put('username', $user->username_una);

        return redirect()->route('user.home');
    }

    /**
     * Handle user logout
     */
    public function logout()
    {
        Session::flush();
        return redirect()->route('login');
    }

    /**
     * Show admin login form
     */
    public function showAdminLogin()
    {
        return view('admins.login');
    }

    /**
     * Handle admin login
     */
    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email_una', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password_una)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput();
        }

        // Check if user is admin
        if ($user->id_role_una != 2) {
            return back()->withErrors([
                'email' => 'Access denied. Admin privileges required.',
            ]);
        }

        // Store user info in session
        Session::put('user_id', $user->id_user_una);
        Session::put('user_role', $user->id_role_una);
        Session::put('username', $user->username_una);

        return redirect()->route('admin.home');
    }

    /**
     * API: Handle user login (强制 Google Authenticator)
     */
    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if user exists
        $user = User::where('email_una', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'no_user',
                'message' => 'User does not exist.'
            ], 404);
        }

        // Check password
        if (!Hash::check($request->password, $user->password_una)) {
            return response()->json([
                'status' => 'pass_fail',
                'message' => 'Incorrect password.'
            ], 401);
        }

        // Google Authenticator 强制验证
        if (!$request->has('ga_code')) {
            // Password correct, now require GA code
            return response()->json([
                'status' => 'ga_required',
                'message' => 'Google Authenticator code required.',
                'email' => $user->email_una
            ]);
        }

        // Verify GA code
        $gaService = new GoogleAuthenticatorService();
        $isValid = $gaService->verifyKey($user->google_auth_una, $request->ga_code);
        
        if (!$isValid) {
            return response()->json([
                'status' => 'ga_fail',
                'message' => 'Invalid Google Authenticator code.'
            ], 401);
        }

        // Store user info in session
        Session::put('user_id', $user->id_user_una);
        Session::put('user_role', $user->id_role_una);
        Session::put('username', $user->username_una);

        // Determine role name
        $roleName = $user->id_role_una == 2 ? 'admin' : 'user';

        return response()->json([
            'status' => 'login_ok',
            'message' => 'Login successful.',
            'role' => $roleName,
            'user' => [
                'id' => $user->id_user_una,
                'username' => $user->username_una,
                'email' => $user->email_una,
                'role_id' => $user->id_role_una
            ]
        ]);
    }

    /**
     * API: Handle user registration
     */
    public function apiRegister(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users_una,email_una',
            'password' => 'required|min:6|confirmed',
        ]);

        // Get User role (id = 1)
        $userRole = Role::where('role_name_una', 'User')->first();

        // Generate Google Authenticator secret
        $gaService = new GoogleAuthenticatorService();
        $secret = $gaService->generateSecretKey();
        $qrCodeUrl = $gaService->getQRCodeImageUrl(
            'UNA Navigator',
            $request->email,
            $secret
        );

        $user = User::create([
            'username_una' => $request->username,
            'email_una' => $request->email,
            'password_una' => Hash::make($request->password),
            'google_auth_una' => $secret, // 强制设置 Google Auth
            'id_role_una' => $userRole->id_role_una ?? 1,
        ]);

        // Store user ID in session for verification
        Session::put('temp_user_id', $user->id_user_una);
        Session::put('temp_email', $user->email_una);

        return response()->json([
            'status' => 'need_ga_setup',
            'message' => 'Please setup Google Authenticator to complete registration.',
            'secret' => $secret,
            'qr_code_url' => $qrCodeUrl,
            'email' => $user->email_una,
            'user_id' => $user->id_user_una
        ], 201);
    }

    /**
     * API: Complete registration by verifying Google Authenticator
     */
    public function completeRegistration(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'code' => 'required|string|size:6',
        ]);

        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404);
        }

        // Verify the code
        $gaService = new GoogleAuthenticatorService();
        $isValid = $gaService->verifyKey($user->google_auth_una, $request->code);

        if (!$isValid) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid verification code. Please try again.'
            ], 400);
        }

        // Complete registration - Auto login
        Session::put('user_id', $user->id_user_una);
        Session::put('user_role', $user->id_role_una);
        Session::put('username', $user->username_una);
        Session::forget('temp_user_id');
        Session::forget('temp_email');

        return response()->json([
            'status' => 'success',
            'message' => 'Registration completed successfully.',
            'user' => [
                'id' => $user->id_user_una,
                'username' => $user->username_una,
                'email' => $user->email_una,
                'role_id' => $user->id_role_una
            ]
        ]);
    }

    /**
     * API: Handle logout
     */
    public function apiLogout(Request $request)
    {
        Session::flush();
        return response()->json([
            'status' => 'success',
            'message' => 'Logout successful.'
        ]);
    }

    /**
     * API: Setup Google Authenticator
     */
    public function setupGoogleAuth(Request $request)
    {
        $userId = Session::get('user_id');
        
        if (!$userId) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated.'
            ], 401);
        }

        $user = User::find($userId);
        $gaService = new GoogleAuthenticatorService();
        
        // Generate new secret
        $secret = $gaService->generateSecretKey();
        
        // Generate QR code image URL
        $qrCodeUrl = $gaService->getQRCodeImageUrl(
            'UNA Navigator',
            $user->email_una,
            $secret
        );

        // Store secret temporarily in session
        Session::put('temp_ga_secret', $secret);

        return response()->json([
            'status' => 'success',
            'secret' => $secret,
            'qr_code_url' => $qrCodeUrl,
            'message' => 'Scan the QR code with Google Authenticator app.'
        ]);
    }

    /**
     * API: Verify and enable Google Authenticator
     */
    public function verifyGoogleAuth(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $userId = Session::get('user_id');
        $tempSecret = Session::get('temp_ga_secret');

        if (!$userId || !$tempSecret) {
            return response()->json([
                'status' => 'error',
                'message' => 'Setup session expired. Please start again.'
            ], 400);
        }

        $gaService = new GoogleAuthenticatorService();
        $isValid = $gaService->verifyKey($tempSecret, $request->code);

        if (!$isValid) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid verification code. Please try again.'
            ], 400);
        }

        // Save secret to user
        $user = User::find($userId);
        $user->google_auth_una = $tempSecret;
        $user->save();

        // Clear temp secret from session
        Session::forget('temp_ga_secret');

        return response()->json([
            'status' => 'success',
            'message' => 'Google Authenticator enabled successfully.'
        ]);
    }

    /**
     * API: Disable Google Authenticator
     */
    public function disableGoogleAuth(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $userId = Session::get('user_id');

        if (!$userId) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated.'
            ], 401);
        }

        $user = User::find($userId);

        if (empty($user->google_auth_una)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Google Authenticator is not enabled.'
            ], 400);
        }

        // Verify code before disabling
        $gaService = new GoogleAuthenticatorService();
        $isValid = $gaService->verifyKey($user->google_auth_una, $request->code);

        if (!$isValid) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid verification code.'
            ], 400);
        }

        // Remove Google Authenticator
        $user->google_auth_una = null;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Google Authenticator disabled successfully.'
        ]);
    }

    /**
     * API: Check Google Authenticator status
     */
    public function checkGoogleAuthStatus(Request $request)
    {
        $userId = Session::get('user_id');

        if (!$userId) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated.'
            ], 401);
        }

        $user = User::find($userId);

        return response()->json([
            'status' => 'success',
            'enabled' => !empty($user->google_auth_una),
            'email' => $user->email_una
        ]);
    }
}

