<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ServiceOfferController;
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
    //Service Offers 
Route::get('/offers', [ServiceOfferController::class, 'index']);
Route::get('/offers/{serviceOffer}', [ServiceOfferController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/offers', [ServiceOfferController::class, 'store']);
    Route::put('/offers/{serviceOffer}', [ServiceOfferController::class, 'update']);
    Route::delete('/offers/{serviceOffer}', [ServiceOfferController::class, 'destroy']);
    Route::get('/my-offers', [ServiceOfferController::class, 'myOffers']);
});
});