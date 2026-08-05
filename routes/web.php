<?php

use App\Http\Controllers\Web\ServiceOfferController;
use App\Http\Controllers\Web\ServiceRequestController;
use App\Http\Controllers\Web\ServiceMatchController;
use App\Http\Controllers\Web\TransactionController;
use App\Http\Controllers\Web\ReviewController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\ApiTokenController;
use App\Http\Controllers\Web\DisputeController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// ── Public routes ──────────────────────────────────────────
Route::get('/', fn() => view('welcome'))->name('welcome');
Route::get('/explorer', [ServiceRequestController::class, 'public'])
    ->name('requests.public');
Route::get('/offres', [ServiceOfferController::class, 'public'])
    ->name('offers.public');
Route::get('/communaute', fn() => view('community'))
    ->name('community');
Route::get('/comment-ca-marche', fn() => view('how-it-works'))
    ->name('how-it-works');

// ── GitHub OAuth ───────────────────────────────────────────
Route::get('/auth/github',
    [\App\Http\Controllers\Auth\GithubController::class, 'redirect'])
    ->name('auth.github');
Route::get('/auth/github/callback',
    [\App\Http\Controllers\Auth\GithubController::class, 'callback'])
    ->name('auth.github.callback');

// ── Protected routes ───────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard',
        [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile',
        [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit',
        [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',
        [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/skills',
        [ProfileController::class, 'skills'])->name('profile.skills');
    Route::post('/profile/skills',
        [ProfileController::class, 'updateSkills'])->name('profile.skills.update');
    Route::delete('/profile',
        [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Service Offers
    Route::get('/offers',
        [ServiceOfferController::class, 'index'])->name('offers.index');
    Route::get('/offers/create',
        [ServiceOfferController::class, 'create'])->name('offers.create');
    Route::post('/offers',
        [ServiceOfferController::class, 'store'])->name('offers.store');
    Route::get('/offers/{serviceOffer}',
        [ServiceOfferController::class, 'show'])->name('offers.show');
    Route::get('/offers/{serviceOffer}/edit',
        [ServiceOfferController::class, 'edit'])->name('offers.edit');
    Route::patch('/offers/{serviceOffer}',
        [ServiceOfferController::class, 'update'])->name('offers.update');
    Route::delete('/offers/{serviceOffer}',
        [ServiceOfferController::class, 'destroy'])->name('offers.destroy');

    // Service Requests
    Route::get('/requests',
        [ServiceRequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/create',
        [ServiceRequestController::class, 'create'])->name('requests.create');
    Route::post('/requests',
        [ServiceRequestController::class, 'store'])->name('requests.store');
    Route::get('/requests/{serviceRequest}',
        [ServiceRequestController::class, 'show'])->name('requests.show');
    Route::get('/requests/{serviceRequest}/edit',
        [ServiceRequestController::class, 'edit'])->name('requests.edit');
    Route::patch('/requests/{serviceRequest}',
        [ServiceRequestController::class, 'update'])->name('requests.update');
    Route::delete('/requests/{serviceRequest}',
        [ServiceRequestController::class, 'destroy'])->name('requests.destroy');

    // Matches
    Route::get('/matches',
        [ServiceMatchController::class, 'index'])->name('matches.index');
    Route::post('/matches',
        [ServiceMatchController::class, 'store'])->name('matches.store');
    Route::get('/matches/{serviceMatch}',
        [ServiceMatchController::class, 'show'])->name('matches.show');
    Route::post('/matches/{serviceMatch}/accept',
        [ServiceMatchController::class, 'accept'])->name('matches.accept');
    Route::post('/matches/{serviceMatch}/refuse',
        [ServiceMatchController::class, 'refuse'])->name('matches.refuse');
    Route::post('/matches/{serviceMatch}/schedule',
        [ServiceMatchController::class, 'schedule'])->name('matches.schedule');
    Route::post('/matches/{serviceMatch}/confirm',
        [ServiceMatchController::class, 'confirm'])->name('matches.confirm');
    Route::get('/sessions',
        [ServiceMatchController::class, 'sessions'])->name('matches.sessions');

    // Disputes
    Route::post('/matches/{serviceMatch}/dispute',
        [DisputeController::class, 'store'])->name('disputes.store');
    Route::get('/disputes/{dispute}',
        [DisputeController::class, 'show'])->name('disputes.show');

    // Transactions
    Route::get('/transactions',
        [TransactionController::class, 'index'])->name('transactions.index');

    // Reviews
    Route::get('/reviews',
        [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews',
        [ReviewController::class, 'store'])->name('reviews.store');

    // API Tokens
    Route::get('/api-tokens',
        [ApiTokenController::class, 'index'])->name('api-tokens.index');
    Route::post('/api-tokens',
        [ApiTokenController::class, 'store'])->name('api-tokens.store');
    Route::delete('/api-tokens/{token}',
        [ApiTokenController::class, 'destroy'])->name('api-tokens.destroy');
});

require __DIR__.'/auth.php';