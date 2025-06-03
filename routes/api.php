<?php

use App\Models\{Category, Item};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('/search')
    ->name('search.')
    ->group(function () {
        Route::get('/category', function (Request $request) {
            return Category::query()
                ->active()
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
                ->map(fn (Category $category) => [
                    'value' => $category->id,
                    'label' => $category->name,
                ]);
        })->name('category');

        Route::get('/item', function (Request $request) {
            return Item::query()
                ->when(
                    $request->boolean('active'),
                    fn (Builder $query) => $query->active()
                )
                ->when(
                    $category = $request->get('category'),
                    fn (Builder $query) => $query->where('category_id', '=', $category),
                )
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
                ->map(fn (Item $item) => [
                    'value' => $item->id,
                    'label' => $item->name,
                ]);
        })->name('item');
    });
