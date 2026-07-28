<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Public routes

Route::prefix('v1')->group(function () {

    Route::post('/login',    [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/users/{username}',           [UserController::class, 'show']);
    Route::get('/users/{username}/stats',     [UserController::class, 'stats']);
    Route::get('/users/{username}/badge.svg', [UserController::class, 'badge']);

    //Protected routes
    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/logout',       [AuthController::class, 'logout']);
        Route::get('/me',            [AuthController::class, 'me']);
        Route::get('/me/balance',    [AuthController::class, 'balance']);
        Route::get('/me/transactions', [AuthController::class, 'transactions']);

    });
});