<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::view('/', 'welcome');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::resource('threads', ThreadController::class)->middleware('auth');


Route::resource('threads', ThreadController::class);
Route::resource('threads.replies', ReplyController::class)->only(['store', 'destroy']);

require __DIR__.'/auth.php';
