<?php

use App\Http\Controllers\TeamController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Route::get('/team/search', [TeamController::class, 'search'])->name('team.search');
    Route::post('/team/{team}/match', [App\Http\Controllers\MatchController::class, 'store'])->name('team.match');
    Route::resource('team', TeamController::class);
    Route::resource('team.schedules', ScheduleController::class);
    
});

require __DIR__.'/auth.php';
