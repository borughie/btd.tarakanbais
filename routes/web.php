<?php

use App\Livewire\Admin\GuestDashboard;
use App\Livewire\Auth\Login;
use App\Livewire\GuestCheckIn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', GuestCheckIn::class)
    ->name('guest.checkin')
    ->middleware('throttle:10,1');

Route::get('/login', Login::class)->name('login');

Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect('/');
})->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/tamu', GuestDashboard::class)->name('admin.guest.dashboard');
});
