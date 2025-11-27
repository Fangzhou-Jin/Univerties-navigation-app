<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/ga/verify', [AuthController::class, 'verifyGA']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

