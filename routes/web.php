<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserDataController;

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

    Route::prefix('superadmin')->middleware('can:superadmin-only')->group(function () {
        Route::prefix('user-data')->group(function () {
            Route::get('/', [UserDataController::class, 'index'])->name('user-data.index');
            Route::post('/store', [UserDataController::class, 'store'])->name('user-data.store');
            Route::get('/edit/{id}', [UserDataController::class, 'edit'])->name('user-data.edit');
            Route::post('/update/{id}', [UserDataController::class, 'update'])->name('user-data.update');
            Route::delete('/destroy/{id}', [UserDataController::class, 'destroy'])->name('user-data.destroy');
        });
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
