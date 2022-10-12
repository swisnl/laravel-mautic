<?php

namespace Swis\Laravel\Mautic;

use Swis\Laravel\Mautic\Facades\Mautic;

trait SynchronizesWithMauticTrait
{
    public static function bootSynchronizesWithMauticTrait()
    {
        static::saving(function ($model) {
            if ($model instanceof SynchronizesWithMautic) {
                $mautic = Mautic::connection($model->getMauticConnection());
                if ($model->getMauticId()) {
                    call_user_func([$mautic, $model->getMauticType()])
                        ->edit($model->getMauticId(), $model->toMauticArray());

                    return;
                }
                $response = call_user_func([$mautic, $model->getMauticType()])
                    ->create($model->toMauticArray());

                $model->setMauticId($response['contact']['id']);
            }
        });
    }

    public function toMauticArray(): array
    {
        return $this->toArray();
    }

    public function getMauticType(): string
    {
        return 'contacts';
    }

    public function getMauticConnection(): string
    {
        return 'main';
    }

    public function getMauticId(): ?string
    {
        return $this->getAttribute($this->getMauticIdField());
    }

    public function setMauticId(string $id): void
    {
        $this->setAttribute($this->getMauticIdField(), $id);
    }

    public function getMauticIdField(): string
    {
        return 'mautic_id';
    }
}
