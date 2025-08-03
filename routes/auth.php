<?php

use App\Http\Controllers\AuthenticatedController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedController::class, 'loginCreate'])->name('login');
    Route::get('/register', [AuthenticatedController::class, 'registerCreate'])->name('register');

    Route::post('login', [AuthenticatedController::class, 'loginStore']);
    Route::post('register', [AuthenticatedController::class, 'registerStore']);
});
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedController::class, 'destroy'])->name('logout');
});