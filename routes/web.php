<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;

Route::get('/', function () {
    return view('welcome');
});


Route::controller(PublicController::class)->group(function () {
    Route::get('transport-rates', 'transportRates')->name('transport-rates');
    Route::get('tour-packages', 'tourPackages')->name('tour-packages');
    Route::get('attractions', 'attractions')->name('attractions');
    Route::get('about', 'about')->name('about');
    Route::get('contact', 'contact')->name('contact');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

