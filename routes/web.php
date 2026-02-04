<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\SettingsController;

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
    Route::get('forgot-password', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Default Dashboard
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Role-based Dashboards
    Route::get('dashboard/superadmin', function () {
        return view('dashboard.superadmin');
    })->name('dashboard.superadmin');

    Route::get('dashboard/admin', function () {
        return view('dashboard.admin');
    })->name('dashboard.admin');

    Route::get('dashboard/driver', function () {
        return view('dashboard.driver');
    })->name('dashboard.driver');

    Route::get('dashboard/company', function () {
        return view('dashboard.company');
    })->name('dashboard.company');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Settings
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');

    // User Management
    Route::resource('users', UserController::class);

    // Customer Management
    Route::resource('customers', CustomerController::class);

    // Vehicle Management
    Route::resource('vehicles', VehicleController::class);
});

