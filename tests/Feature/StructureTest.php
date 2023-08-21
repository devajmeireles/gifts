<?php

test('cannot dump')
    ->expect(['dd', 'dump', 'ray'])
    ->not
    ->toBeUsed();

test('cannot use sleep')
    ->expect(['sleep'])
    ->not
    ->toBeUsed();
