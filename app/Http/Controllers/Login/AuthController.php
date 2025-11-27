<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\Login\RegisterRequest;
use App\Http\Requests\Login\LoginRequest;
use App\Http\Requests\Login\VerifyGARequest;
use App\Services\Login\AuthService;

class AuthController extends Controller
{
    public function register(RegisterRequest $r, AuthService $svc)
    {
        return response()->json($svc->register($r->validated()));
    }

    public function verifyGA(VerifyGARequest $r, AuthService $svc)
    {
        return response()->json($svc->verifyGA($r->validated()));
    }

    public function login(LoginRequest $r, AuthService $svc)
    {
        return response()->json($svc->login($r->validated()));
    }

    public function logout(AuthService $svc)
    {
        return response()->json($svc->logout());
    }
}

