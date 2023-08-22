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

        Route::controller(ItemController::class)
            ->prefix('/items')
            ->name('items.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/export', 'export')->name('export');
            });

        Route::get('/categories', CategoryController::class)->name('categories');

        Route::controller(SignatureController::class)
            ->prefix('/signatures')
            ->name('signatures.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/export', 'export')->name('export');
            });

        Route::middleware(UnauthorizeSettingsPageAccess::class)
            ->get('/settings', SettingsController::class)
            ->name('settings');

        Route::middleware(UnauthorizeUserPageAccess::class)
            ->get('/users', UserController::class)
            ->name('users');
    });

require __DIR__ . '/auth.php';

require __DIR__ . '/frontend.php';
