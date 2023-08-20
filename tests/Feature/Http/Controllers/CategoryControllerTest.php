<?php

use App\Http\Livewire\Category\Index;

use function Pest\Laravel\get;

it('can access', function () {
    createTestUser();

    get(route('admin.categories'))
        ->assertOk()
        ->assertSeeLivewire(Index::class);
});
