<?php

declare(strict_types=1);

use App\Livewire\Season\Show as SeasonShow;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('organization-settings', 'organization.settings-form')
    ->middleware(['auth', 'verified'])
    ->name('organization.settings-form');

Route::view('seasons', 'season.index')
    ->middleware(['auth', 'verified'])
    ->name('season.index');

Route::get('seasons/{season:uuid}', SeasonShow::class)
    ->middleware(['auth', 'verified'])
    ->name('season.show');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
