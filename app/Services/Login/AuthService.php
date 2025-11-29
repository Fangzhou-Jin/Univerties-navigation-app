<?php

namespace App\Services\Login;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class AuthService {
    public function register($d)
    {
        if (User::where('email', $d['email'])->exists()) {
            return ['status' => 'register_fail', 'message' => 'User already exists'];
        }

        $key = $this->pendingKey($d['email']);

        // Generate Base32 encoded secret key (16 characters, compliant with Google Authenticator standard)
        $secret = $this->generateBase32Secret(16);
        Cache::put($key, [
            'email' => $d['email'],
            'password_hash' => password_hash($d['password'], PASSWORD_BCRYPT),
            'google_auth_secret' => $secret,
        ], now()->addMinutes(10));

        return ['status'=>'need_ga_verify','secret'=>$secret];
    }

    private function pendingKey(string $email): string
    {
        return 'pending_reg_' . md5(strtolower($email));
    }

    private function generateBase32Secret($length = 16)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567'; // Base32 character set
        $secret = '';
        for ($i = 0; $i < $length; $i++) {
            $secret .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $secret;
    }

    public function verifyGA($d)
    {
        $key = $this->pendingKey($d['email']);
        $pending = Cache::get($key);
        if (!$pending) {
            return ['status'=>'ga_fail','message'=>'Registration information does not exist or has expired'];
        }
        if (User::where('email', $d['email'])->exists()) {
            Cache::forget($key);
            return ['status'=>'ga_fail','message'=>'User already exists, please login directly'];
        }

        $svc = new GoogleAuthService;
        if(!$svc->check($pending['google_auth_secret'], $d['code'])) {
            return ['status'=>'ga_fail'];
        }

        User::create([
            'email' => $pending['email'],
            'password_hash' => $pending['password_hash'],
            'google_auth_secret' => $pending['google_auth_secret'],
            'google_auth_enabled' => 1,
            'role' => 'user',
        ]);

        Cache::forget($key);

        return ['status'=>'ga_ok'];
    }

    public function login($d)
{
    $u = User::where('email', $d['email'])->first();
    if (!$u) return ['status' => 'no_user'];
    if (!password_verify($d['password'], $u->password_hash)) return ['status' => 'pass_fail'];

    // Decide redirect based on role
    // Admin -> /admins/home, normal user -> /users/home
    $redirect = ($u->role === 'admin') ? '/admins/home' : '/users/home';

    // If Google Authenticator is enabled, handle GA flow
    if ($u->google_auth_enabled == 1) {

        // If GA code provided -> verify it
        if (isset($d['ga_code'])) {
            $svc = new GoogleAuthService;
            if (!$svc->check($u->google_auth_secret, $d['ga_code'])) {
                return ['status' => 'ga_required', 'message' => 'Incorrect verification code'];
            }

            // 登录成功，存储 session
            session([
                'user_id' => $u->id,
                'user_email' => $u->email,
                'user_role' => $u->role,
            ]);

            return [
                'status'   => 'login_ok',
                'role'     => $u->role,
                'redirect' => $redirect,
            ];
        }

        // GA code not provided -> ask for it
        return [
            'status'  => 'ga_required',
            'message' => 'Please enter Google Authenticator code',
        ];
    }

    // No Google Authenticator enabled -> normal login
    // 登录成功，存储 session
    session([
        'user_id' => $u->id,
        'user_email' => $u->email,
        'user_role' => $u->role,
    ]);

    return [
        'status'   => 'login_ok',
        'role'     => $u->role,
        'redirect' => $redirect,
    ];
}

    public function logout()
    {
        // 清除所有 session 数据
        session()->flush();
        
        return ['status' => 'logout_ok'];
    }
}
