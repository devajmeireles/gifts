<?php

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/category', function (Request $request) {
    ray($request->all());

    return Category::query()
        ->when(
            $search = $request->get('search'),
            fn ($query) => $query->where('name', 'like', "%{$search}%")
        )
        ->when(
            $selected = $request->get('selected'),
            fn (Builder $query) => $query->whereIn('id', $selected),
        )
        ->limit($search || $selected ? 50 : 10)
        ->get()
        ->map(fn (Category $category) => $category->only('id', 'name'));
})->name('category');
