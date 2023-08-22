<?php

use App\Http\Livewire\Signature\Index;

use function Pest\Laravel\get;

it('can access', function () {
    createTestUser();

    get(route('admin.signatures.index'))
        ->assertOk()
        ->assertSeeLivewire(Index::class);
});
