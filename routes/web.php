<?php

use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\CriteriaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('pages.dashboard.index', [
        "title" => "Dashboard",
        "menu" => "Dashboard",
    ]);
});
Route::get('/login', function () {
    return view('layouts.guest.login', [
        "title" => "Login",
    ]);
});
// layout 2
Route::get('/home', function () {
    return view('pages.custumer-page.home.index', [
        "title" => "Home",
        "menu" => "Home",
    ]);
});

// Alternative
Route::get('spk/destinasi/alternative/wisata', [AlternativeController::class, 'index'])->name('spk/destinasi/alternative.index');
Route::get('spk/destinasi/alternative/wisata/create', [AlternativeController::class, 'create'])->name('spk/destinasi/alternative.create');
Route::post('spk/destinasi/alternative/wisata/store', [AlternativeController::class, 'store'])->name('spk/destinasi/alternative.store');
Route::get('spk/destinasi/alternative/wisata/edit/{id}', [AlternativeController::class, 'edit'])->name('spk/destinasi/alternative.edit');
Route::put('spk/destinasi/alternative/wisata/update', [AlternativeController::class, 'update'])->name('spk/destinasi/alternative.update');
Route::delete('spk/destinasi/alternative/wisata/destroy', [AlternativeController::class, 'destroy'])->name('spk/destinasi/alternative.destroy');

// Criteria
Route::get('spk/destinasi/kriteria/wisata', [CriteriaController::class, 'index'])->name('spk/destinasi/kriteria.index');
Route::get('spk/destinasi/kriteria/wisata/create', [CriteriaController::class, 'create'])->name('spk/destinasi/kriteria.create');
Route::post('spk/destinasi/kriteria/wisata/store', [CriteriaController::class, 'store'])->name('spk/destinasi/kriteria.store');
Route::get('spk/destinasi/kriteria/wisata/edit/{id}', [CriteriaController::class, 'edit'])->name('spk/destinasi/kriteria.edit');
Route::put('spk/destinasi/kriteria/wisata/update/{id}', [CriteriaController::class, 'update'])->name('spk/destinasi/kriteria.update');
Route::delete('spk/destinasi/kriteria/wisata/destroy', [CriteriaController::class, 'destroy'])->name('spk/destinasi/kriteria.destroy');
