<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\PublicProfileController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\SkillController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('skills', SkillController::class);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
});

// Admin Routes
Route::middleware(['auth:sanctum', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::post('/users', [AdminController::class, 'addUser']);
    Route::post('/projects', [AdminController::class, 'addProject']);
    Route::get('/users', [AdminController::class, 'listUsers']);
    Route::put('/users/{user}', [AdminController::class, 'editUser']);
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser']);
    Route::get('/projects', [AdminController::class, 'listProjects']);
    Route::put('/projects/{project}', [AdminController::class, 'editProject']);
    Route::delete('/projects/{project}', [AdminController::class, 'deleteProject']);
});

Route::get('/profiles/{user:name}', [PublicProfileController::class, 'show']);