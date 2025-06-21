<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\StatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Tags API Resource
    Route::apiResource('tags', TagController::class);

    // Posts API Resource
    Route::get('/posts/deleted', [PostController::class, 'showDeleted']);
    Route::post('/posts/{id}/restore', [PostController::class, 'restore']);
    Route::apiResource('posts', PostController::class);

    // Stats API
    Route::get('/stats', [StatController::class, 'index']);
});
