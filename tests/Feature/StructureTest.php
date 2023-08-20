<?php

test('cannot dump')
    ->expect(['dd', 'dump', 'ray'])
    ->not
    ->toBeUsed();
