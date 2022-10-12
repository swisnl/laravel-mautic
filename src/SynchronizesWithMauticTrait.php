<?php

namespace Swis\Laravel\Mautic;

use Swis\Laravel\Mautic\Facades\Mautic;

trait SynchronizesWithMauticTrait
{
    public static function bootSynchronizesWithMauticTrait()
    {
        static::saving(function ($model) {
            if ($model instanceof SynchronizesWithMautic) {
                if ($model->getMauticId()) {
                    call_user_func([Mautic::class, $model->mauticType()])
                        ->edit($model->getMauticId(), $model->toMauticArray());

                    return;
                }
                $response = call_user_func([Mautic::class, $model->mauticType()])
                    ->create($model->toMauticArray());

                $model->setMauticId($response['contact']['id']);
            }
        });
    }

    public function toMauticArray(): array
    {
        return $this->toArray();
    }

    public function mauticType(): string
    {
        return 'contacts';
    }

    public function getMauticIdField(): string
    {
        return 'mautic_id';
    }

    public function getMauticId(): ?string
    {
        return $this->getAttribute($this->getMauticIdField());
    }

    public function setMauticId(string $id): void
    {
        $this->setAttribute($this->getMauticIdField(), $id);
    }
}
