<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AiController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LandingPageController;

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (JWT)
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {
    // Public
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    // Protected
    Route::middleware('jwt')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
        Route::put('profile', [AuthController::class, 'updateProfile']);
        Route::put('update', [AuthController::class, 'updateProfile']);
        Route::post('change-password', [AuthController::class, 'changePassword']);
    });
});

/*
|--------------------------------------------------------------------------
| AI CONSULT ROUTE
|--------------------------------------------------------------------------
*/
Route::post('/ai/consult', [AiController::class, 'consult'])->middleware('jwt');

/*
|--------------------------------------------------------------------------
| PROJECT ROUTES (Protected with JWT)
|--------------------------------------------------------------------------
*/
Route::prefix('projects')->middleware('jwt')->group(function () {
    Route::get('/', [ProjectController::class, 'index']);
    Route::get('stats', [ProjectController::class, 'stats']);
    Route::get('{id}', [ProjectController::class, 'show']);
    Route::put('{id}', [ProjectController::class, 'update']);
    Route::delete('{id}', [ProjectController::class, 'destroy']);

    // Task operations
    Route::post('{id}/tasks', [ProjectController::class, 'storeTask']);
    Route::put('{id}/tasks/{index}', [ProjectController::class, 'updateTask']);
    Route::delete('{id}/tasks/{index}', [ProjectController::class, 'destroyTask']);
    Route::put('{id}/tasks/{index}/toggle', [ProjectController::class, 'toggleTask']);

    // AI Enhanced tools
    Route::post('{id}/ai-expand', [ProjectController::class, 'aiExpandTasks']);
    Route::post('{id}/ai-swot', [ProjectController::class, 'aiSwot']);
    Route::post('{id}/ai-pitch', [ProjectController::class, 'aiPitch']);
    Route::post('{id}/ai-regenerate', [ProjectController::class, 'aiRegenerate']);
});

/*
|--------------------------------------------------------------------------
| USER CRUD (Protected with JWT)
|--------------------------------------------------------------------------
*/
Route::prefix('users')->middleware('jwt')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('{id}', [UserController::class, 'show']);
    Route::post('/', [UserController::class, 'store']);
    Route::put('{id}', [UserController::class, 'update']);
    Route::delete('{id}', [UserController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| LANDING PAGE BUILDER & AUTO-HOSTING ROUTES (Protected with JWT)
|--------------------------------------------------------------------------
*/
Route::prefix('landing-page')->middleware('jwt')->group(function () {
    Route::get('/', [LandingPageController::class, 'index']);
    Route::get('{id}', [LandingPageController::class, 'show']);
    Route::post('generate', [LandingPageController::class, 'generate']);
    Route::post('save', [LandingPageController::class, 'save']);
    Route::delete('{id}', [LandingPageController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['jwt', 'role:admin'])->group(function () {
    Route::get('stats', [AdminController::class, 'stats']);
    Route::get('users', [AdminController::class, 'users']);
    Route::put('users/{id}/role', [AdminController::class, 'updateUserRole']);
    Route::delete('users/{id}', [AdminController::class, 'deleteUser']);
    Route::get('projects', [AdminController::class, 'allProjects']);
    Route::get('landing-pages', [AdminController::class, 'allLandingPages']);
    Route::delete('landing-pages/{id}', [AdminController::class, 'deleteLandingPage']);
});
