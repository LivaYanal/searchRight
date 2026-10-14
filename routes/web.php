<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyStatusController;
use Illuminate\Support\Facades\Route;

// Alleen voor bezoekers die nog NIET ingelogd zijn
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);

    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])
        ->middleware('throttle:5,1'); // max 5 pogingen per minuut
});

// Alleen voor ingelogde gebruikers
Route::middleware('auth')->group(function () {
    Route::get('/', BoardController::class)->name('board');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::resource('companies', CompanyController::class);
    Route::patch('/companies/{company}/status', CompanyStatusController::class)->name('companies.status');
    Route::patch('/companies/{company}/application', [ApplicationController::class, 'update'])->name('companies.application');
});
