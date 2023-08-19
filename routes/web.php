<?php

use App\Http\Controllers\{CategoryController,
    DashboardController,
    ItemController,
    ProfileController,
    SettingsController,
    SignatureController};
use App\Http\Middleware\UnauthorizeSettingsPageAccess;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware('auth')
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//

Route::get('/items', ItemController::class)->name('items');
Route::get('/categories', CategoryController::class)->name('categories');
Route::get('/signatures', SignatureController::class)->name('signatures');
Route::middleware(UnauthorizeSettingsPageAccess::class)
    ->get('/settings', SettingsController::class)->name('settings');

require __DIR__ . '/auth.php';
