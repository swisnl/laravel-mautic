<?php

namespace Swis\Laravel\Mautic\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Swis\Laravel\Mautic\Facades\Mautic;
use Swis\Laravel\Mautic\SynchronizesWithMautic;

class PersistModelInMautic implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(protected Model $model)
    {
    }

    public function handle(): void
    {
        if (!$this->model instanceof SynchronizesWithMautic) {
            return;
        }

        $mautic = Mautic::connection($this->model->getMauticConnection());
        $mauticObject = call_user_func([$mautic, $this->model->getMauticType()]);
        if ($this->model->getMauticId()) {
            $mauticObject->edit($this->model->getMauticId(), $this->model->toMauticArray());

            return;
        }
        $response = $mauticObject->create($this->model->toMauticArray());

        $this->model->setMauticId($response[$mauticObject->itemName()]['id']);

        $this->model->saveQuietly();
    }
}
