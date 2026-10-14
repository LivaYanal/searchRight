<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

// Startpagina: ingelogd -> bedrijven, anders -> inloggen
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('companies.index')
        : redirect()->route('login');
});

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
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::resource('companies', CompanyController::class)->except('show');
});
