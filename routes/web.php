<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\TrelloController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/trello', [TrelloController::class, 'index'])
//     ->middleware(['auth:sanctum', 'verified'])
//     ->name('trellodash');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/trello', [TrelloController::class, 'index'])->name('trellodash');

    Route::post('/trello',[TrelloController::class, 'store'])->name('trellosave');
    
    Route::post('/orders',[TrelloController::class, 'storeOrder'])->name('ordersave');



});


// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->name('dashboard');


// Route::middleware(['auth:sanctum', 'verified'])
//     ->get('/trello', [TrelloController::class, 'index'])
//     ->name('trellodash');


// Route::middleware(['auth:sanctum', 'verified'])->get('/template', function () {
//     return Inertia::render('AppTemplate');
// })->name('templatedash');