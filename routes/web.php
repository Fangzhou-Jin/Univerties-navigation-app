<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which contains the "web" middleware group.
|
*/

/*
|--------------------------------------------------------------------------
| Public Routes - 公开访问路由
|--------------------------------------------------------------------------
*/

// 首页和介绍页
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/intro', function () {
    return view('landing');
})->name('intro');

/*
|--------------------------------------------------------------------------
| Admin Routes - 管理员路由（没有注册功能）
|--------------------------------------------------------------------------
*/

Route::prefix('admins')->name('admins.')->group(function () {
    // 公开访问 - 管理员登录
    Route::get('/login', function () {
        return view('admins.login');
    })->name('login');
    
    // 需要管理员权限的路由
    Route::middleware('admin.check')->group(function () {
        Route::get('/home', function () {
            return view('admins.home');
        })->name('home');
        
        Route::get('/profile', function () {
            return view('admins.profile');
        })->name('profile');
        
        Route::get('/modify', function () {
            return view('admins.modify');
        })->name('modify');
    });
});

/*
|--------------------------------------------------------------------------
| User Routes - 用户路由（有注册功能）
|--------------------------------------------------------------------------
*/

Route::prefix('users')->name('users.')->group(function () {
    // 公开访问 - 登录和注册
    Route::get('/login', function () {
        return view('users.login');
    })->name('login');
    
    Route::get('/register', function () {
        return view('users.register');
    })->name('register');
    
    // 需要登录的用户路由
    Route::middleware('auth.check')->group(function () {
        Route::get('/home', function () {
            return view('users.home');
        })->name('home');
        
        Route::get('/profile', function () {
            return view('users.profile');
        })->name('profile');
    });
});

/*
|--------------------------------------------------------------------------
| Legacy Routes - 向后兼容的旧路由（可选保留）
|--------------------------------------------------------------------------
|
| 这些路由保留了旧的 URL 结构，确保现有链接不会失效
| 如果确认不再需要，可以删除此部分
|
*/

// 旧的登录和注册路由
Route::redirect('/login', '/users/login')->name('legacy.login');
Route::redirect('/register', '/users/register')->name('legacy.register');
Route::redirect('/admin-login', '/admins/login')->name('legacy.admin.login');

// 旧的主页路由
Route::middleware('auth.check')->group(function () {
    Route::redirect('/main', '/users/home')->name('legacy.main');
    Route::redirect('/home', '/users/home')->name('legacy.home');
});

Route::middleware('admin.check')->group(function () {
    Route::redirect('/admin', '/admins/home')->name('legacy.admin');
});
