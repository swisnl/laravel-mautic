<?php

namespace Swis\Laravel\Mautic\Tests;

use Illuminate\Support\Facades\Bus;
use Swis\Laravel\Mautic\Jobs\DeleteModelFromMautic;
use Swis\Laravel\Mautic\Jobs\PersistModelInMautic;
use Swis\Laravel\Mautic\Tests\mock\Jobs\DummyDeleteFromMautic;
use Swis\Laravel\Mautic\Tests\mock\Jobs\DummyPersistInMautic;
use Swis\Laravel\Mautic\Tests\mock\Segment;

it('uses the save job defined in the model', function () {
    $segment = new Segment(['name' => 'Foo']);

    Bus::fake();

    $segment->save();

    Bus::assertNotDispatched(PersistModelInMautic::class);
    Bus::assertDispatched(DummyPersistInMautic::class);
});

it('uses the delete job defined in the model', function () {
    $segment = new Segment(['name' => 'Foo']);
    $segment->saveQuietly();

    Bus::fake();

    $segment->delete();

    Bus::assertNotDispatched(DeleteModelFromMautic::class);
    Bus::assertDispatched(DummyDeleteFromMautic::class);
});
