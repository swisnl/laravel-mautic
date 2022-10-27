<?php

namespace Swis\Laravel\Mautic\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Swis\Laravel\Mautic\Exceptions\SynchronisationException;
use Swis\Laravel\Mautic\Facades\Mautic;

class DeleteModelFromMautic implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(
        protected string $mauticId,
        protected string $mauticType,
        protected ?string $mauticConnection = null
    ) {
    }

    public function handle(): void
    {
        $mautic = Mautic::connection($this->mauticConnection);
        $mauticObject = call_user_func([$mautic, $this->mauticType]);
        $response = $mauticObject->delete($this->mauticId);

        if (isset($response['errors'])) {
            throw new SynchronisationException($response['errors'][0]['message'], $response['errors'][0]['code']);
        }
    }
}
