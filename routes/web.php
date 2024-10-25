<?php

use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\CustumerController;
use App\Http\Controllers\PerformanceRatingController;
use App\Http\Controllers\SubCriteriaController;
use App\Http\Controllers\TravelCategoryController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('pages.dashboard.index', [
            "title" => "Dashboard",
            "menu" => "Dashboard",
        ]);
    });
    // Alternative
    Route::get('spk/destinasi/alternative/wisata', [AlternativeController::class, 'index'])->name('spk/destinasi/alternative.index');
    Route::get('spk/destinasi/alternative/wisata/create', [AlternativeController::class, 'create'])->name('spk/destinasi/alternative.create');
    Route::post('spk/destinasi/alternative/wisata/store', [AlternativeController::class, 'store'])->name('spk/destinasi/alternative.store');
    Route::get('spk/destinasi/alternative/wisata/show/{id}', [AlternativeController::class, 'show'])->name('spk/destinasi/alternative.show');
    Route::get('spk/destinasi/alternative/wisata/edit/{id}', [AlternativeController::class, 'edit'])->name('spk/destinasi/alternative.edit');
    Route::put('spk/destinasi/alternative/wisata/update/{id}', [AlternativeController::class, 'update'])->name('spk/destinasi/alternative.update');
    Route::delete('spk/destinasi/alternative/wisata/destroy/{id}', [AlternativeController::class, 'destroy'])->name('spk/destinasi/alternative.destroy');
    Route::put('spk/destinasi/alternative/wisata/confirm/{id}', [AlternativeController::class, 'confirm'])->name('spk/destinasi/alternative.confirm');

    // Criteria
    Route::get('spk/destinasi/kriteria/wisata', [CriteriaController::class, 'index'])->name('spk/destinasi/kriteria.index');
    Route::get('spk/destinasi/kriteria/wisata/create', [CriteriaController::class, 'create'])->name('spk/destinasi/kriteria.create');
    Route::post('spk/destinasi/kriteria/wisata/store', [CriteriaController::class, 'store'])->name('spk/destinasi/kriteria.store');
    Route::get('spk/destinasi/kriteria/wisata/edit/{id}', [CriteriaController::class, 'edit'])->name('spk/destinasi/kriteria.edit');
    Route::put('spk/destinasi/kriteria/wisata/update/{id}', [CriteriaController::class, 'update'])->name('spk/destinasi/kriteria.update');
    Route::delete('spk/destinasi/kriteria/wisata/destroy/{id}', [CriteriaController::class, 'destroy'])->name('spk/destinasi/kriteria.destroy');
    Route::put('spk/destinasi/kriteria/wisata/activated/{id}', [CriteriaController::class, 'activated'])->name('spk/destinasi/kriteria.activated');
    
    // SubCriteria
    Route::get('spk/destinasi/sub/kriteria/wisata/create/{id}', [SubCriteriaController::class, 'create'])->name('spk/destinasi/sub/kriteria.create');
    Route::post('spk/destinasi/sub/kriteria/wisata/store/{id}', [SubCriteriaController::class, 'store'])->name('spk/destinasi/sub/kriteria.store');
    Route::get('spk/destinasi/sub/kriteria/wisata/edit/{id}', [SubCriteriaController::class, 'edit'])->name('spk/destinasi/sub/kriteria.edit');
    Route::put('spk/destinasi/sub/kriteria/wisata/update/{id}', [SubCriteriaController::class, 'update'])->name('spk/destinasi/sub/kriteria.update');
    Route::delete('spk/destinasi/sub/kriteria/wisata/destroy/{id}', [SubCriteriaController::class, 'destroy'])->name('spk/destinasi/sub/kriteria.destroy');
    
    // Penilaian (R)
    Route::get('spk/destinasi/penilaian/wisata/index', [PerformanceRatingController::class, 'index'])->name('spk/destinasi/penilaian.index');
    Route::post('spk/destinasi/penilaian/wisata/store', [PerformanceRatingController::class, 'store'])->name('spk/destinasi/penilaian.store');
    Route::get('spk/destinasi/penilaian/wisata/edit/{id}', [PerformanceRatingController::class, 'edit'])->name('spk/destinasi/penilaian.edit');
    Route::put('spk/destinasi/penilaian/wisata/update/{id}', [PerformanceRatingController::class, 'update'])->name('spk/destinasi/penilaian.update');
    Route::delete('spk/destinasi/penilaian/wisata/destroy/{id}', [PerformanceRatingController::class, 'destroy'])->name('spk/destinasi/penilaian.destroy');
    
});

Route::middleware('admin')->group(function () {    
    // Kategori Wisata
    Route::get('spk/destinasi/kategori/wisata/index', [TravelCategoryController::class, 'index'])->name('spk/destinasi/kategori/wisata.index');
    Route::get('spk/destinasi/kategori/wisata/create', [TravelCategoryController::class, 'create'])->name('spk/destinasi/kategori/wisata.create');
    Route::post('spk/destinasi/kategori/wisata/store', [TravelCategoryController::class, 'store'])->name('spk/destinasi/kategori/wisata.store');
    Route::get('spk/destinasi/kategori/wisata/edit/{id}', [TravelCategoryController::class, 'edit'])->name('spk/destinasi/kategori/wisata.edit');
    Route::put('spk/destinasi/kategori/wisata/update/{id}', [TravelCategoryController::class, 'update'])->name('spk/destinasi/kategori/wisata.update');
    Route::delete('spk/destinasi/kategori/wisata/destroy/{id}', [TravelCategoryController::class, 'destroy'])->name('spk/destinasi/kategori/wisata.destroy');
    
    // User
    Route::get('spk/destinasi/user/index', [UserController::class, 'index'])->name('spk/destinasi/user.index');
    Route::get('spk/destinasi/user/create', [UserController::class, 'create'])->name('spk/destinasi/user.create');
    Route::post('spk/destinasi/user/store', [UserController::class, 'store'])->name('spk/destinasi/user.store');
    Route::get('spk/destinasi/user/edit/{id}', [UserController::class, 'edit'])->name('spk/destinasi/user.edit');
    Route::put('spk/destinasi/user/update/{id}', [UserController::class, 'update'])->name('spk/destinasi/user.update');
    Route::delete('spk/destinasi/user/destroy/{id}', [UserController::class, 'destroy'])->name('spk/destinasi/user.destroy');
});


// customer page
// Route::middleware('guest')->group(function () {
    Route::get('/', [CustumerController::class, 'wisataIndex'])->name('spk/destinasi/home.index');
    Route::get('spk/destinasi/wisata/detail/{id}', [CustumerController::class, 'wisataShow'])->name('spk/destinasi/wisata.show');
    Route::get('spk/destinasi/rekomendasi/create', [CustumerController::class, 'rekomendasiCreate'])->name('spk/destinasi/rekomendasi.create');
    Route::post('spk/destinasi/rekomendasi/store', [CustumerController::class, 'rekomendasiStore'])->name('spk/destinasi/rekomendasi.store');
    Route::get('spk/destinasi/rekomendasi/riwayat/{id}', [CustumerController::class, 'lastHistory'])->name('spk/destinasi/rekomendasi.riwayat');
// });


require __DIR__.'/auth.php';