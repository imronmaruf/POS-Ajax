<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserDataController;
use App\Http\Controllers\Owner\StoreCategoriesController;
use App\Http\Controllers\Owner\StoreController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::prefix('user-data')->middleware('can:owner-only')->group(function () {
        Route::get('/', [UserDataController::class, 'index'])->name('user-data.index');
        Route::post('/store', [UserDataController::class, 'store'])->name('user-data.store');
        Route::get('/create', [UserDataController::class, 'create'])->name('user-data.create');
        Route::get('/edit/{id}', [UserDataController::class, 'edit'])->name('user-data.edit');
        Route::post('/update/{id}', [UserDataController::class, 'update'])->name('user-data.update');
        Route::delete('/destroy/{id}', [UserDataController::class, 'destroy'])->name('user-data.destroy');
    });

    Route::prefix('store-categories')->middleware('can:owner-only')->group(function () {
        Route::get('/', [StoreCategoriesController::class, 'index'])->name('store-categories.index');
        Route::post('/store', [StoreCategoriesController::class, 'store'])->name('store-categories.store');
        Route::get('/edit/{id}', [StoreCategoriesController::class, 'edit'])->name('store-categories.edit');
        Route::post('/update/{id}', [StoreCategoriesController::class, 'update'])->name('store-categories.update');
        Route::delete('/destroy/{id}', [StoreCategoriesController::class, 'destroy'])->name('store-categories.destroy');
    });

    Route::prefix('store-data')->middleware('can:owner-only')->group(function () {
        Route::get('/', [StoreController::class, 'index'])->name('store-data.index');
        Route::get('/create', [StoreController::class, 'create'])->name('store-data.create');
        Route::post('/store', [StoreController::class, 'store'])->name('store-data.store');
        Route::get('/edit/{id}', [StoreController::class, 'edit'])->name('store-data.edit');
        Route::post('/update/{id}', [StoreController::class, 'update'])->name('store-data.update');
        Route::delete('/destroy/{id}', [StoreController::class, 'destroy'])->name('store-data.destroy');
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
