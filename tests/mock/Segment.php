<?php

namespace Swis\Laravel\Mautic\Tests\mock;

use Illuminate\Database\Eloquent\Model;
use Swis\Laravel\Mautic\SynchronizesWithMautic;
use Swis\Laravel\Mautic\SynchronizesWithMauticTrait;
use Swis\Laravel\Mautic\Tests\mock\Jobs\DummyPersistInMautic;

class Segment extends Model implements SynchronizesWithMautic
{
    use SynchronizesWithMauticTrait;

    protected $fillable = ['name'];

    public function getMauticType(): string
    {
        return 'segments';
    }

    public function getOnDeletedJob()
    {
        return null;
    }

    public function getOnSavedJob(): DummyPersistInMautic
    {
        return new DummyPersistInMautic($this);
    }
}
