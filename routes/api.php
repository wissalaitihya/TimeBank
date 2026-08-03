<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceOfferController;
use App\Http\Controllers\Api\ServiceRequestController;
use App\Http\Controllers\Api\ServiceMatchController;
use App\Http\Controllers\ApiReviewController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Public routes

Route::prefix('v1')->group(function () {

    Route::post('/login',    [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

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
// Public
Route::get('/requests', [ServiceRequestController::class, 'index']);
Route::get('/requests/{serviceRequest}', [ServiceRequestController::class, 'show']);

// Protected
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/requests', [ServiceRequestController::class, 'store']); 
    Route::put('/requests/{serviceRequest}', [ServiceRequestController::class, 'update']);
    Route::delete('/requests/{serviceRequest}', [ServiceRequestController::class, 'destroy']);
    Route::get('/my-requests', [ServiceRequestController::class, 'myRequests']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/matches',                        [ServiceMatchController::class, 'index']);
    Route::post('/matches',                       [ServiceMatchController::class, 'store']);
    Route::get('/matches/{serviceMatch}',         [ServiceMatchController::class, 'show']);
    Route::post('/matches/{serviceMatch}/accept', [ServiceMatchController::class, 'accept']);
    Route::post('/matches/{serviceMatch}/refuse', [ServiceMatchController::class, 'refuse']);
    Route::post('/matches/{serviceMatch}/schedule',[ServiceMatchController::class, 'schedule']);
    Route::post('/matches/{serviceMatch}/confirm',[ServiceMatchController::class, 'confirm']);
    Route::post('/matches/{serviceMatch}/dispute',[ServiceMatchController::class, 'dispute']);

});
// Public
Route::get('/users/{username}/reviews', [ApiReviewController::class, 'userReviews']);
Route::get('/matches/{serviceMatch}/reviews', [ApiReviewController::class, 'matchReviews']);

// Protected
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/reviews', [ApiReviewController::class, 'store']);
    Route::get('/my-reviews', [ApiReviewController::class, 'myReviews']);
});
});
