<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SubtaskController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // عمومی
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // محافظت شده
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);

        Route::get('/tasks/stats', [TaskController::class, 'stats']);
        Route::patch('/tasks/{task}/toggle-status', [TaskController::class, 'toggleStatus']);
        Route::apiResource('tasks', TaskController::class);

        Route::patch('/subtasks/{subtask}/toggle', [SubtaskController::class, 'toggle']);
    });
});
