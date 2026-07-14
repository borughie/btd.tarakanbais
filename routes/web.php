<?php

use App\Http\Controllers\GuestExportController;
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

    Route::prefix('admin/export')->name('admin.export.')->group(function () {
        Route::get('/word', [GuestExportController::class, 'index'])->name('word');
        Route::get('/excel', [GuestExportController::class, 'excel'])->name('excel');
        Route::get('/pdf', [GuestExportController::class, 'pdf'])->name('pdf');
    });
});
