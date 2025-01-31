<?php

namespace Swis\Laravel\Mautic\Tests\mock\Jobs;

use Illuminate\Database\Eloquent\Model;

class DummyPersistInMautic
{
    public function __construct(private readonly Model $model) {}

    public function handle(): void
    {
        echo sprintf('persisted %s', $this->model->getKey());
    }
}
