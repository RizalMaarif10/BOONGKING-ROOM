<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomController as AdminRoom;
use App\Http\Controllers\Admin\BookingController as AdminBooking;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\JenisRuanganController;

use App\Http\Controllers\User\RoomController as UserRoom;
use App\Http\Controllers\User\BookingController as UserBooking;

use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| HALAMAN AWAL
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (!Auth::check()) {
        return redirect('/login');
    }

    if (Auth::user()->role == 'admin') {
        return redirect('/admin/dashboard');
    }

    return redirect('/rooms');
});


/*
|--------------------------------------------------------------------------
| ROUTE DASHBOARD (WAJIB ADA UNTUK LOGIN BREEZE)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->get('/dashboard', function () {

    if (Auth::user()->role == 'admin') {
        return redirect('/admin/dashboard');
    }

    return redirect('/rooms');
})->name('dashboard');


/*
|--------------------------------------------------------------------------
| USER AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // daftar ruangan
    Route::get('/rooms', [UserRoom::class, 'index'])->name('rooms');
    Route::get('/schedule', [UserBooking::class, 'schedule'])->name('schedule');
    Route::get('/schedule/data', [UserBooking::class, 'scheduleData']);
    Route::get('/booking/slots', [UserBooking::class, 'getSlots'])->name('booking.slots');

    // booking user
    Route::get('/booking', [UserBooking::class, 'index'])->name('booking.index');
    Route::get('/booking/create', [UserBooking::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [UserBooking::class, 'store'])->name('booking.store');
});


/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        -------------------------
        DASHBOARD ADMIN
        -------------------------
        */

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


        /*
        -------------------------
        MANAJEMEN RUANGAN
        -------------------------
        */

        Route::resource('rooms', AdminRoom::class);


        /*
        -------------------------
        JENIS RUANGAN
        -------------------------
        */

        Route::resource('jenis-ruangan', JenisRuanganController::class)
            ->except(['show', 'create', 'edit']);


        /*
        -------------------------
        APPROVAL BOOKING
        -------------------------
        */

        Route::get('/bookings', [AdminBooking::class, 'index'])->name('bookings');
        Route::post('/booking/{id}/approve', [AdminBooking::class, 'approve'])->name('booking.approve');
        Route::post('/booking/{id}/reject', [AdminBooking::class, 'reject'])->name('booking.reject');


        /*
        -------------------------
        MANAJEMEN USER
        -------------------------
        */

        Route::resource('users', UserController::class);
    });


/*
|--------------------------------------------------------------------------
| PROFILE USER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
