<?php

use App\Http\Controllers\Auth\GithubController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::get('/auth/github', [GithubController::class, 'redirect'])->name('auth.github');
Route::get('/auth/github/callback', [GithubController::class, 'callback'])->name('auth.github.callback');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.show');
    Route::get('/requests', [\App\Http\Controllers\Web\ServiceRequestController::class, 'index'])
        ->name('requests.index');
    Route::get('/requests/create', [\App\Http\Controllers\Web\ServiceRequestController::class, 'create'])
        ->name('requests.create');
    Route::get('/offers', [\App\Http\Controllers\Web\ServiceOfferController::class, 'index'])
        ->name('offers.index');
    Route::get('/offers/create', [\App\Http\Controllers\Web\ServiceOfferController::class, 'create'])
        ->name('offers.create');
    Route::get('/matches', [\App\Http\Controllers\Web\ServiceMatchController::class, 'index'])
        ->name('matches.index');
    Route::get('/matches/{serviceMatch}', [\App\Http\Controllers\Web\ServiceMatchController::class, 'show'])
        ->name('matches.show');
    Route::get('/transactions', [\App\Http\Controllers\Web\TransactionController::class, 'index'])
        ->name('transactions.index');
    Route::get('/reviews', [\App\Http\Controllers\Web\ReviewController::class, 'index'])
        ->name('reviews.index');
    Route::get('/api-tokens', [\App\Http\Controllers\Web\ApiTokenController::class, 'index'])
        ->name('api-tokens.index');
    Route::get('/profile/skills', [ProfileController::class, 'skills'])
        ->name('profile.skills');
});

Route::get('/', function () { return view('welcome'); })->name('welcome');
Route::get('/explorer', function () { return view('requests.public'); })->name('requests.public');
Route::get('/offres', function () { return view('offers.public'); })->name('offers.public');
Route::get('/communaute', function () { return view('community'); })->name('community');
Route::get('/comment-ca-marche', function () { return view('how-it-works'); })->name('how-it-works');


require __DIR__.'/auth.php';
