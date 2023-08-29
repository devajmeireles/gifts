<?php

use App\Exports\Presence\PresenceExport;
use App\Models\Presence;
use Maatwebsite\Excel\Facades\Excel;

use function Pest\Laravel\get;

beforeEach(fn () => createTestUser());

it('can generate export', function () {
    Excel::fake();

    $file     = sprintf('presenças-%s.xlsx', now()->format('Y-m-d_H:i'));
    $presence = Presence::factory()->create();

    get(route('admin.presences.export'));

    Excel::assertDownloaded($file, function (PresenceExport $export) use ($presence) {
        return $export->collection()->contains($presence);
    });
});

it('can generate empty export', function () {
    Excel::fake();

    $file = sprintf('presenças-%s.xlsx', now()->format('Y-m-d_H:i'));

    get(route('admin.presences.export'));

    Excel::assertDownloaded($file, function (PresenceExport $export) {
        return $export->collection()->isEmpty();
    });
});
