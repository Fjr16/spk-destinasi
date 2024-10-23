<?php

use App\Http\Controllers\AuthenticatedController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedController::class, 'loginCreate'])->name('login');

    Route::post('login', [AuthenticatedController::class, 'loginStore']);
});
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedController::class, 'destroy'])->name('logout');
});