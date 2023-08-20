<?php

use App\Http\Controllers\Auth\{
    AuthenticatedSessionController,
    PasswordController
};
use Illuminate\Support\Facades\Route;

Route::middleware('guest')
    ->prefix('/admin')
    ->name('admin.')
    ->group(function () {
        Route::controller(AuthenticatedSessionController::class)
            ->group(function () {
                Route::get('login', 'create')->name('login');
                Route::post('login', 'store');
            });
    });

Route::middleware('auth')
    ->prefix('/admin')
    ->name('admin.')
    ->group(function () {
        Route::put('password', PasswordController::class)->name('password.update');

        Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
    });
