<?php

use App\Http\Livewire\Layout\Notification;

test('cannot dump')
    ->expect(['dd', 'dump', 'ray'])
    ->not
    ->toBeUsed();

test('cannot use sleep')
    ->expect(['sleep'])
    ->not
    ->toBeUsed()
    ->ignoring(Notification::class);
