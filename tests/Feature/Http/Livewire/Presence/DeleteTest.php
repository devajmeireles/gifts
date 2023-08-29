<?php

use App\Http\Livewire\Presence\Delete;
use App\Models\Presence;

use function Pest\Laravel\assertModelMissing;
use function Pest\Livewire\livewire;

it('can delete', function () {
    $presence = Presence::factory()->create();

    livewire(Delete::class)
        ->set('presence', $presence)
        ->call('delete')
        ->assertEmittedUp('presence::index::refresh');

    assertModelMissing($presence);
});
