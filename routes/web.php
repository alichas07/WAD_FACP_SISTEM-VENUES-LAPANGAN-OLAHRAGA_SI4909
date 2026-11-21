<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\RentalItemController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\CoachController;

// 1. ROUTE TAMU / GUEST (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Buat Akun Baru dari halaman Login
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
});

// 2. ROUTE WAJIB LOGIN (Middleware 'auth')
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', function () {
        return redirect()->route('coaches.index');
    });

    // Dapat diakses User Biasa & Admin (Lihat tabel & cari/filter)
    Route::get('/venues', [VenueController::class, 'index'])->name('venues.index');
    Route::get('/rentals', [RentalItemController::class, 'index'])->name('rentals.index');
    Route::get('/members', [MemberController::class, 'index'])->name('members.index');
    Route::get('/coaches', [CoachController::class, 'index'])->name('coaches.index');

    // Khusus Admin (Tambah, Edit, Hapus)
    Route::middleware('admin')->group(function () {
        Route::resource('venues', VenueController::class)->except(['index', 'show']);
        Route::resource('rentals', RentalItemController::class)->except(['index', 'show']);
        Route::resource('members', MemberController::class)->except(['index', 'show']);
        Route::resource('coaches', CoachController::class)->except(['index', 'show']);
    });

    // Detail per ID
    Route::get('/venues/{venue}', [VenueController::class, 'show'])->name('venues.show');
    Route::get('/rentals/{rental}', [RentalItemController::class, 'show'])->name('rentals.show');
    Route::get('/members/{member}', [MemberController::class, 'show'])->name('members.show');
    Route::get('/coaches/{coach}', [CoachController::class, 'show'])->name('coaches.show');
});