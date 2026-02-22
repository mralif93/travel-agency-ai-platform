<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\ForcePasswordChangeController;
use App\Http\Controllers\CustomerForcePasswordChangeController;
use App\Http\Controllers\TourPackageController;
use App\Http\Controllers\AttractionController;

Route::get('/', function () {
    return view('welcome');
});


Route::controller(PublicController::class)->group(function () {
    Route::get('/transport-rates', [PublicController::class, 'transportRates'])->name('transport-rates');
    Route::post('/book', [BookingController::class, 'store'])->name('book.store');
    Route::get('/booking/{id}', [BookingController::class, 'show'])->name('booking.confirmation');
    Route::get('/booking/{id}/invoice', [BookingController::class, 'downloadInvoice'])->name('booking.invoice');
    Route::get('tour-packages', 'tourPackages')->name('tour-packages');
    Route::get('tour-packages/{tourPackage}', 'tourPackageShow')->name('tour-packages.show');
    Route::get('attractions', 'attractions')->name('attractions');
    Route::get('attractions/{attraction}', 'attractionShow')->name('attractions.show');
    Route::get('about', 'about')->name('about');
    Route::get('contact', 'contact')->name('contact');
});

Route::middleware('guest')->group(function () {
    // Customer Auth (Default Root)
    Route::get('login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [CustomerAuthController::class, 'login']);
    Route::get('register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [CustomerAuthController::class, 'register']);

    // Admin/Staff Auth
    Route::prefix('admin')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('admin.login');
        Route::post('login', [AuthController::class, 'login']);
        Route::get('forgot-password', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Force Password Change (AJAX)
    Route::post('/password/change', [ForcePasswordChangeController::class, 'update'])->name('password.change.update');

    // Default Dashboard (Fallback)
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Role-based Dashboards (Explicit Paths)
    Route::get('admin/dashboard/super', [DashboardController::class, 'superadmin'])->name('dashboard.superadmin');
    Route::get('admin/dashboard', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::get('driver/dashboard', [DashboardController::class, 'driver'])->name('dashboard.driver');
    Route::get('company/dashboard', [DashboardController::class, 'company'])->name('dashboard.company');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Settings
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');

    // User Management
    Route::post('users/{user}/toggle-force-password', [UserController::class, 'toggleForcePasswordChange'])->name('users.toggle-force-password');
    Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::resource('users', UserController::class);

    // Customer Management
    Route::post('customers/{customer}/toggle-force-password', [CustomerController::class, 'toggleForcePasswordChange'])->name('customers.toggle-force-password');
    Route::post('customers/{customer}/reset-password', [CustomerController::class, 'resetPassword'])->name('customers.reset-password');
    Route::resource('customers', CustomerController::class);

    // Vehicle Management
    Route::resource('vehicles', VehicleController::class);

    // Order Management
    Route::post('orders/{order}/verify', [OrderController::class, 'verify'])->name('orders.verify');
    Route::resource('orders', OrderController::class);

    // Company Management
    Route::resource('companies', CompanyController::class);

    // Invoice Management
    Route::resource('invoices', InvoiceController::class);

    // Tour Package Management (Admin)
    Route::post('admin/tour-packages/{tourPackage}/toggle-featured', [TourPackageController::class, 'toggleFeatured'])->name('admin.tour-packages.toggle-featured');
    Route::post('admin/tour-packages/{tourPackage}/toggle-active', [TourPackageController::class, 'toggleActive'])->name('admin.tour-packages.toggle-active');
    Route::resource('admin/tour-packages', TourPackageController::class)->names('admin.tour-packages');

    // Attraction Management (Admin)
    Route::post('admin/attractions/{attraction}/toggle-featured', [AttractionController::class, 'toggleFeatured'])->name('admin.attractions.toggle-featured');
    Route::post('admin/attractions/{attraction}/toggle-active', [AttractionController::class, 'toggleActive'])->name('admin.attractions.toggle-active');
    Route::post('admin/attractions/reviews/{review}/approve', [AttractionController::class, 'approveReview'])->name('admin.attractions.reviews.approve');
    Route::post('admin/attractions/reviews/{review}/reject', [AttractionController::class, 'rejectReview'])->name('admin.attractions.reviews.reject');
    Route::delete('admin/attractions/reviews/{review}', [AttractionController::class, 'deleteReview'])->name('admin.attractions.reviews.destroy');
    Route::resource('admin/attractions', AttractionController::class)->names('admin.attractions');
});

// Customer Dashboard Route
Route::middleware(['auth:customer'])->group(function () {
    // Force Password Change (AJAX)
    Route::post('customer/password/change', [CustomerForcePasswordChangeController::class, 'update'])->name('customer.password.change.update');

    Route::get('customer/dashboard', [DashboardController::class, 'customer'])->name('dashboard.customer');
    Route::get('customer/trips', [DashboardController::class, 'trips'])->name('customer.trips');
    Route::get('customer/trips/{order}', [DashboardController::class, 'showTrip'])->name('customer.trips.show');
    Route::get('customer/trips/{order}/print', [DashboardController::class, 'printTrip'])->name('customer.trips.print');

    // Profile Routes
    Route::get('customer/profile', [\App\Http\Controllers\CustomerProfileController::class, 'edit'])->name('customer.profile.edit');
    Route::patch('customer/profile', [\App\Http\Controllers\CustomerProfileController::class, 'update'])->name('customer.profile.update');

    Route::post('customer/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');
});

// Redirect root to customer login if not auth, or landing page
// Keep existing root


