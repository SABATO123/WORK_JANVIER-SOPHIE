<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Passenger\DashboardController as PassengerDashboard;
use App\Http\Controllers\Admin\BusController;
use App\Http\Controllers\Admin\RouteController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\PassengerController;

// Public Routes
Route::get('/', function () {
    $buses = \App\Models\Bus::with(['routes' => function($query) {
        $query->whereDate('departure_time', '>=', now())
              ->where('status', 'active')
              ->orderBy('departure_time');
    }])->latest()->get();
    return view('home', compact('buses'));
})->name('home');

Route::get('/routes', [\App\Http\Controllers\RouteController::class, 'index'])->name('routes.index');

// Redirect /dashboard to appropriate dashboard based on role
Route::get('/dashboard', function () {
    if (auth()->check()) {
        return redirect()->route(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'passenger.dashboard');
    }
    return redirect()->route('login');
})->name('dashboard');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->middleware('auth')->middleware(\App\Http\Middleware\CheckRole::class . ':admin')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
    
    // Bus Management Routes
    Route::resource('buses', BusController::class)->names([
        'index' => 'admin.buses.index',
        'create' => 'admin.buses.create',
        'store' => 'admin.buses.store',
        'show' => 'admin.buses.show',
        'edit' => 'admin.buses.edit',
        'update' => 'admin.buses.update',
        'destroy' => 'admin.buses.destroy',
    ]);

    // Route Management Routes
    Route::resource('routes', RouteController::class)->names([
        'index' => 'admin.routes.index',
        'create' => 'admin.routes.create',
        'store' => 'admin.routes.store',
        'show' => 'admin.routes.show',
        'edit' => 'admin.routes.edit',
        'update' => 'admin.routes.update',
        'destroy' => 'admin.routes.destroy',
    ]);

    // Booking Management Routes
    Route::resource('bookings', BookingController::class)->names([
        'index' => 'admin.bookings.index',
        'create' => 'admin.bookings.create',
        'store' => 'admin.bookings.store',
        'show' => 'admin.bookings.show',
        'edit' => 'admin.bookings.edit',
        'update' => 'admin.bookings.update',
        'destroy' => 'admin.bookings.destroy',
    ]);

    // Passenger Management Routes
    Route::resource('passengers', PassengerController::class)->names([
        'index' => 'admin.passengers.index',
        'show' => 'admin.passengers.show',
        'edit' => 'admin.passengers.edit',
        'update' => 'admin.passengers.update',
        'destroy' => 'admin.passengers.destroy',
    ])->except(['create', 'store']);
});

// Passenger Routes
// Guest accessible route for booking form (will redirect to login)
Route::get('/routes/{route}/book', [PassengerDashboard::class, 'showBookingForm'])
    ->name('passenger.routes.book.form')
    ->middleware('auth');

Route::prefix('passenger')->middleware('auth')->middleware(\App\Http\Middleware\CheckRole::class . ':passenger')->group(function () {
    Route::get('/dashboard', [PassengerDashboard::class, 'index'])->name('passenger.dashboard');
    Route::get('/routes', [PassengerDashboard::class, 'getAllRoutes'])->name('passenger.routes.index');
    Route::get('/routes/{route}/book', [PassengerDashboard::class, 'showBookingForm'])->name('passenger.routes.book.form');
    Route::post('/routes/{route}/book', [PassengerDashboard::class, 'bookTicket'])->name('passenger.routes.book');
    Route::get('/bookings', [PassengerDashboard::class, 'viewBookings'])->name('passenger.bookings.index');
    Route::get('/bookings/{booking}', [PassengerDashboard::class, 'showBooking'])->name('passenger.bookings.show');
    Route::patch('/bookings/{booking}/cancel', [PassengerDashboard::class, 'cancelBooking'])->name('passenger.bookings.cancel');
});
