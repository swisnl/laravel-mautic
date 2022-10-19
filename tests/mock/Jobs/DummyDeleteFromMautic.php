<?php

namespace Swis\Laravel\Mautic\Tests\mock\Jobs;

use Illuminate\Database\Eloquent\Model;

class DummyDeleteFromMautic
{
    public function __construct(private readonly Model $model)
    {
    }

    public function handle(): void
    {
        echo sprintf('deleted %s', $this->model->getKey());
    }
}
