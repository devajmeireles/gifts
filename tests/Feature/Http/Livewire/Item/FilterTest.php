<?php

use App\Exports\Item\ItemExport;
use App\Http\Livewire\Item\{Filter, Index};
use App\Models\{Category, Item};
use Maatwebsite\Excel\Facades\Excel;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can filter category', function () {
    Item::factory()
        ->for($category = Category::factory()->activated()->create())
        ->activated()
        ->create();

    livewire(Filter::class)
        ->set('category', $category->id)
        ->call('filter')
        ->assertEmittedUp('item::index::filter', [
            'category' => $category->id,
        ]);
});

it('cannot filter using zero filters', function () {
    livewire(Filter::class)
        ->call('filter')
        ->assertDispatchedBrowserEvent('wireui:notification')
        ->assertNotEmitted('item::index::filter');
});

it('can view filtered', function () {
    $one = Item::factory()
        ->for($category = Category::factory()->activated()->create())
        ->activated()
        ->create();

    $two = Item::factory()
        ->activated()
        ->create();

    livewire(Index::class)
        ->call('filter', [
            'category' => $category->id,
        ])
        ->assertSee($one->name)
        ->assertDontSee($two->name);
});

it('can generate export', function () {
    Excel::fake();

    $file = sprintf('itens-%s.xlsx', now()->format('Y-m-d_H:i'));

    $one = Item::factory()
        ->for($category = Category::factory()->activated()->create())
        ->activated()
        ->create();

    $two = Item::factory()
        ->activated()
        ->create();

    get(route('admin.items.export', ['category' => $category->id]));

    Excel::assertDownloaded($file, function (ItemExport $export) use ($one, $two) {
        return $export->collection()->contains($one) &&
            $export->collection()->doesntContain($two);
    });
});

it('can generate empty export', function () {
    Excel::fake();

    $file = sprintf('itens-%s.xlsx', now()->format('Y-m-d_H:i'));

    $category = Category::factory()
        ->activated()
        ->create();

    get(route('admin.items.export', ['category' => $category->id]));

    Excel::assertDownloaded($file, function (ItemExport $export) {
        return $export->collection()->isEmpty();
    });
});
