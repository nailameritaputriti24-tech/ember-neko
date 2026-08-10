<?php

use App\Http\Controllers\Cms\AboutController;
use App\Http\Controllers\Cms\AuthController;
use App\Http\Controllers\Cms\LocationController;
use App\Http\Controllers\Cms\MethodologyController;
use App\Http\Controllers\Cms\ReferenceController;
use App\Http\Controllers\Cms\TeamController;
use App\Http\Controllers\User\ContentController;
use App\Http\Controllers\User\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])
    ->name('user.dashboard');
Route::get('/map', [ContentController::class, 'map'])->name('user.map');
Route::get('/locations/{id}', [ContentController::class, 'location'])->name('user.locations.show');
Route::get('/search', [ContentController::class, 'search'])->name('user.search');
Route::get('/about', [ContentController::class, 'about'])->name('user.about');
Route::get('/team', [ContentController::class, 'team'])->name('user.team');
Route::get('/methodology', [ContentController::class, 'methodology'])->name('user.methodology');

Route::prefix('cms')->name('cms.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])
            ->middleware('throttle:5,1')
            ->name('login.store');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/', fn () => redirect()->route('cms.locations.index'))->name('dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/about', [AboutController::class, 'edit'])->name('about.edit');
        Route::put('/about', [AboutController::class, 'update'])->name('about.update');

        Route::get('/methodology', [MethodologyController::class, 'edit'])->name('methodology.edit');
        Route::put('/methodology', [MethodologyController::class, 'update'])->name('methodology.update');

        Route::get('/team', [TeamController::class, 'index'])->name('team.index');
        Route::post('/team', [TeamController::class, 'store'])->name('team.store');
        Route::delete('/team/{id}', [TeamController::class, 'destroy'])->name('team.destroy');

        Route::get('/reference', [ReferenceController::class, 'index'])->name('references.index');
        Route::post('/reference', [ReferenceController::class, 'store'])->name('references.store');
        Route::delete('/reference/{id}', [ReferenceController::class, 'destroy'])->name('references.destroy');

        Route::get('/titik-lokasi', [LocationController::class, 'index'])->name('locations.index');
        Route::get('/titik-lokasi/create', [LocationController::class, 'create'])->name('locations.create');
        Route::post('/titik-lokasi', [LocationController::class, 'store'])->name('locations.store');
        Route::get('/titik-lokasi/{id}', [LocationController::class, 'show'])->name('locations.show');
        Route::get('/titik-lokasi/{id}/edit', [LocationController::class, 'edit'])->name('locations.edit');
        Route::put('/titik-lokasi/{id}', [LocationController::class, 'update'])->name('locations.update');

        Route::get('/map-input', fn () => redirect()->route('cms.locations.index'))->name('map-input');
    });
});
