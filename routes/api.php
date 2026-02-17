<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\CommentController;

Route::prefix(config('app.version'))
    ->middleware(['api.log'])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | User APIs (Public)
        |--------------------------------------------------------------------------
        */
        Route::controller(AuthController::class)->group(function () {
            Route::post('/register', 'register');
            Route::post('/login', 'login');
        });

        /*
        |--------------------------------------------------------------------------
        | Protected APIs
        |--------------------------------------------------------------------------
        */
        Route::middleware('auth:sanctum')->group(function () {

            Route::controller(AuthController::class)->group(function () {
                Route::post('/logout', 'logout');
                Route::get('/me', 'me');
            });

            /*
            |--------------------------------------------------------------------------
            | Project APIs
            |--------------------------------------------------------------------------
            */
            Route::controller(ProjectController::class)->group(function () {
                Route::get('/projects', 'index');
                Route::get('/projects/{project}', 'show');
            });

            Route::middleware('role:admin')->controller(ProjectController::class)->group(function () {
                Route::post('/projects', 'store');
                Route::put('/projects/{project}', 'update');
                Route::delete('/projects/{project}', 'destroy');
            });

            /*
            |--------------------------------------------------------------------------
            | Task APIs
            |--------------------------------------------------------------------------
            */
            Route::controller(TaskController::class)->group(function () {
                Route::get('/projects/{project}/tasks', 'tasksByProject');
                Route::get('/tasks/{task}', 'show');
                Route::put('/tasks/{task}', 'update');

            });

            Route::middleware('role:manager')->controller(TaskController::class)->group(function () {
                Route::post('/projects/{project}/tasks', 'storeForProject');
                Route::delete('/tasks/{task}', 'destroy');
            });

            /*
            |--------------------------------------------------------------------------
            | Comment APIs
            |--------------------------------------------------------------------------
            */
            Route::controller(CommentController::class)->group(function () {
                Route::get('/tasks/{task}/comments', 'index');
                Route::post('/tasks/{task}/comments', 'store');
            });
        });
    });
