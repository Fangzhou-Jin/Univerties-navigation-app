<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\PathController;
use App\Http\Controllers\DepartmentController;

/*
|--------------------------------------------------------------------------
| Public Routes - 公开访问路由
|--------------------------------------------------------------------------
*/

// Intro page
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/intro', [HomeController::class, 'index'])->name('intro');

/*
|--------------------------------------------------------------------------
| Authentication Routes - 认证路由
|--------------------------------------------------------------------------
*/

// User Authentication
Route::get('/users/login', [AuthController::class, 'showLogin'])->name('users.login');
Route::post('/users/login', [AuthController::class, 'login'])->name('users.login.post');
Route::get('/users/register', [AuthController::class, 'showRegister'])->name('users.register');
Route::post('/users/register', [AuthController::class, 'register'])->name('users.register.post');

// Admin Authentication
Route::get('/admins/login', [AuthController::class, 'showAdminLogin'])->name('admins.login');
Route::post('/admins/login', [AuthController::class, 'adminLogin'])->name('admins.login.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');

/*
|--------------------------------------------------------------------------
| User Routes - 用户路由（需要登录）
|--------------------------------------------------------------------------
*/

Route::middleware('auth.check')->prefix('users')->name('users.')->group(function () {
    Route::get('/home', [HomeController::class, 'userHome'])->name('home');
    Route::get('/profile', [HomeController::class, 'userProfile'])->name('profile');
    Route::post('/profile', [HomeController::class, 'updateProfile'])->name('profile.update');
    Route::get('/google-auth', function () {
        return view('users.google-auth');
    })->name('google-auth');
});

/*
|--------------------------------------------------------------------------
| Admin Routes - 管理员路由（需要管理员权限）
|--------------------------------------------------------------------------
*/

Route::middleware('admin.check')->prefix('admins')->name('admins.')->group(function () {
    Route::get('/home', [HomeController::class, 'adminHome'])->name('home');
    Route::get('/profile', [HomeController::class, 'adminProfile'])->name('profile');
    Route::post('/profile', [HomeController::class, 'updateProfile'])->name('profile.update');
    
    // Admin can modify data
    Route::get('/modify', function () {
        return view('admins.modify');
    })->name('modify');
});

/*
|--------------------------------------------------------------------------
| API Routes - 数据接口路由
|--------------------------------------------------------------------------
*/

// Public API routes for admin home page (no auth required for displaying data)
Route::prefix('api/public')->group(function () {
    // Universities
    Route::get('/universities', [UniversityController::class, 'index'])->name('api.public.universities.index');
    
    // Buildings
    Route::get('/buildings', [BuildingController::class, 'index'])->name('api.public.buildings.index');
    Route::get('/buildings/university/{universityId}', [BuildingController::class, 'getByUniversity'])->name('api.public.buildings.byUniversity');
    Route::get('/buildings/{buildingId}/floors', [BuildingController::class, 'getFloorsByBuilding'])->name('api.public.buildings.floors');
    Route::get('/floors', [BuildingController::class, 'getAllFloors'])->name('api.public.floors.all');
    
    // Rooms
    Route::get('/rooms', [RoomController::class, 'index'])->name('api.public.rooms.index');
    Route::get('/rooms/search', [RoomController::class, 'search'])->name('api.public.rooms.search');
    
    // Room Types
    Route::get('/room-types', [RoomController::class, 'getRoomTypes'])->name('api.public.room-types.index');
});

Route::prefix('api')->middleware('auth.check')->group(function () {
    
    // Universities
    Route::get('/universities', [UniversityController::class, 'index'])->name('api.universities.index');
    Route::get('/universities/{id}', [UniversityController::class, 'show'])->name('api.universities.show');
    
    // Buildings
    Route::get('/buildings', [BuildingController::class, 'index'])->name('api.buildings.index');
    Route::get('/buildings/{id}', [BuildingController::class, 'show'])->name('api.buildings.show');
    Route::get('/buildings/university/{universityId}', [BuildingController::class, 'getByUniversity'])->name('api.buildings.byUniversity');
    
    // Rooms
    Route::get('/rooms', [RoomController::class, 'index'])->name('api.rooms.index');
    Route::get('/rooms/{id}', [RoomController::class, 'show'])->name('api.rooms.show');
    Route::get('/rooms/search', [RoomController::class, 'search'])->name('api.rooms.search');
    
    // Paths
    Route::get('/paths', [PathController::class, 'index'])->name('api.paths.index');
    Route::get('/paths/{id}', [PathController::class, 'show'])->name('api.paths.show');
    Route::get('/paths/find/{roomAId}/{roomBId}', [PathController::class, 'findPath'])->name('api.paths.find');
    
    // Departments
    Route::get('/departments', [DepartmentController::class, 'index'])->name('api.departments.index');
    Route::get('/departments/{id}', [DepartmentController::class, 'show'])->name('api.departments.show');
    Route::get('/departments/university/{universityId}', [DepartmentController::class, 'getByUniversity'])->name('api.departments.byUniversity');
});

/*
|--------------------------------------------------------------------------
| Admin API Routes - 管理员数据修改接口
|--------------------------------------------------------------------------
*/

Route::prefix('api/admin')->middleware('admin.check')->group(function () {
    
    // Users CRUD
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('api.admin.users.index');
    Route::get('/users/{id}', [\App\Http\Controllers\UserController::class, 'show'])->name('api.admin.users.show');
    Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('api.admin.users.store');
    Route::put('/users/{id}', [\App\Http\Controllers\UserController::class, 'update'])->name('api.admin.users.update');
    Route::delete('/users/{id}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('api.admin.users.destroy');
    Route::get('/roles', [\App\Http\Controllers\UserController::class, 'getRoles'])->name('api.admin.roles.index');
    
    // Universities CRUD
    Route::get('/universities', [UniversityController::class, 'index'])->name('api.admin.universities.index');
    Route::get('/universities/{id}', [UniversityController::class, 'show'])->name('api.admin.universities.show');
    Route::post('/universities', [UniversityController::class, 'store'])->name('api.admin.universities.store');
    Route::put('/universities/{id}', [UniversityController::class, 'update'])->name('api.admin.universities.update');
    Route::delete('/universities/{id}', [UniversityController::class, 'destroy'])->name('api.admin.universities.destroy');
    
    // Buildings CRUD
    Route::get('/buildings', [BuildingController::class, 'index'])->name('api.admin.buildings.index');
    Route::get('/buildings/{id}', [BuildingController::class, 'show'])->name('api.admin.buildings.show');
    Route::post('/buildings', [BuildingController::class, 'store'])->name('api.admin.buildings.store');
    Route::put('/buildings/{id}', [BuildingController::class, 'update'])->name('api.admin.buildings.update');
    Route::delete('/buildings/{id}', [BuildingController::class, 'destroy'])->name('api.admin.buildings.destroy');
    
    // Rooms CRUD
    Route::get('/rooms', [RoomController::class, 'index'])->name('api.admin.rooms.index');
    Route::get('/rooms/{id}', [RoomController::class, 'show'])->name('api.admin.rooms.show');
    Route::post('/rooms', [RoomController::class, 'store'])->name('api.admin.rooms.store');
    Route::put('/rooms/{id}', [RoomController::class, 'update'])->name('api.admin.rooms.update');
    Route::delete('/rooms/{id}', [RoomController::class, 'destroy'])->name('api.admin.rooms.destroy');
    
    // Room Types and Availability
    Route::get('/room-types', [RoomController::class, 'getRoomTypes'])->name('api.admin.room-types.index');
    Route::get('/availability', [RoomController::class, 'getAvailability'])->name('api.admin.availability.index');
    
    // Paths CRUD
    Route::post('/paths', [PathController::class, 'store'])->name('api.admin.paths.store');
    Route::put('/paths/{id}', [PathController::class, 'update'])->name('api.admin.paths.update');
    Route::delete('/paths/{id}', [PathController::class, 'destroy'])->name('api.admin.paths.destroy');
    
    // Departments CRUD
    Route::post('/departments', [DepartmentController::class, 'store'])->name('api.admin.departments.store');
    Route::put('/departments/{id}', [DepartmentController::class, 'update'])->name('api.admin.departments.update');
    Route::delete('/departments/{id}', [DepartmentController::class, 'destroy'])->name('api.admin.departments.destroy');
    
    // Statistics
    Route::get('/stats', function() {
        return response()->json([
            'users' => \App\Models\User::count(),
            'universities' => \App\Models\University::count(),
            'buildings' => \App\Models\Building::count(),
            'rooms' => \App\Models\Room::count(),
            'free_rooms' => \App\Models\Room::where('id_availability_una', 1)->count(),
            'occupied_rooms' => \App\Models\Room::where('id_availability_una', 2)->count(),
        ]);
    })->name('api.admin.stats');
});

/*
|--------------------------------------------------------------------------
| Legacy Routes - 向后兼容的旧路由
|--------------------------------------------------------------------------
*/

Route::middleware('auth.check')->group(function () {
    Route::redirect('/main', '/users/home')->name('legacy.main');
});

Route::middleware('admin.check')->group(function () {
    Route::redirect('/admin', '/admins/home')->name('legacy.admin');
});
