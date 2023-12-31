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
        Route::controller(PasswordController::class)
            ->name('password.')
            ->group(function () {
                Route::get('/password', 'edit')->name('edit');
                Route::patch('/password', 'update')->name('update');
            });

        Route::get('logout', [
            AuthenticatedSessionController::class, 'destroy',
        ])->name('logout');
    });
