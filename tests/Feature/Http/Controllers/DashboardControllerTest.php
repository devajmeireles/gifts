<?php

use App\Http\Livewire\Dashboard\{Card, Chart};

use function Pest\Laravel\get;

it('can access', function () {
    createTestUser();

    get(route('admin.dashboard'))
        ->assertOk()
        ->assertSeeLivewire(Card::class)
        ->assertSeeLivewire(Chart::class);
});
