<?php

use App\Http\Controllers\{CategoryController,
    DashboardController,
    ItemController,
    ProfileController,
    SettingsController,
    SignatureController,
    UserController
};
use App\Http\Middleware\{Admin\UnauthorizeSettingsPageAccess, Admin\UnauthorizeUserPageAccess};
use Illuminate\Support\Facades\Route;

Route::middleware('auth')
    ->prefix('/admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');

        Route::controller(ProfileController::class)
            ->name('profile.')
            ->group(function () {
                Route::get('/profile', 'edit')->name('edit');
                Route::patch('/profile', 'update')->name('update');
                Route::delete('/profile', 'destroy')->name('destroy');
            });

        Route::get('/items', ItemController::class)->name('items');
        Route::get('/categories', CategoryController::class)->name('categories');
        Route::get('/signatures', SignatureController::class)->name('signatures');

        Route::middleware(UnauthorizeSettingsPageAccess::class)
            ->get('/settings', SettingsController::class)
            ->name('settings');

        Route::middleware(UnauthorizeUserPageAccess::class)
            ->get('/users', UserController::class)
            ->name('users');
    });

require __DIR__ . '/auth.php';

require __DIR__ . '/frontend.php';
