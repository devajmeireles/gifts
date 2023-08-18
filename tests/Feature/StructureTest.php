<?php

test('cannot dump')
    ->expect(['dd', 'dump'])
    ->not
    ->toBeUsed();
