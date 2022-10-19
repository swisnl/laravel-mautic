<?php

namespace Swis\Laravel\Mautic\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Swis\Laravel\Mautic\Facades\Mautic;
use Swis\Laravel\Mautic\SynchronizesWithMautic;

class DeleteModelFromMautic implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(protected Model $model)
    {
    }

    public function handle(): void
    {
        if (! $this->model instanceof SynchronizesWithMautic || ! $this->model->getMauticId()) {
            return;
        }

        $mautic = Mautic::connection($this->model->getMauticConnection());
        $mauticObject = call_user_func([$mautic, $this->model->getMauticType()]);
        $mauticObject->delete($this->model->getMauticId());
    }
}
