<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Authentication routes
Route::post('/register', [AuthController::class, 'apiRegister']);
Route::post('/register/complete', [AuthController::class, 'completeRegistration']);
Route::post('/login', [AuthController::class, 'apiLogin']);
Route::post('/logout', [AuthController::class, 'apiLogout']);

// Google Authenticator routes
Route::post('/google-auth/setup', [AuthController::class, 'setupGoogleAuth']);
Route::post('/google-auth/verify', [AuthController::class, 'verifyGoogleAuth']);
Route::post('/google-auth/disable', [AuthController::class, 'disableGoogleAuth']);
Route::get('/google-auth/status', [AuthController::class, 'checkGoogleAuthStatus']);

