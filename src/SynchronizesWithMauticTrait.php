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
                $mauticObject = call_user_func([$mautic, $model->getMauticType()]);
                if ($model->getMauticId()) {
                    $mauticObject->edit($model->getMauticId(), $model->toMauticArray());

                    return;
                }
                $response = $mauticObject->create($model->toMauticArray());

                $model->setMauticId($response[$mauticObject->itemName()]['id']);
            }
        });
    }

    public function toMauticArray(): array
    {
        return $this->toArray();
    }

    public function getMauticConnection(): ?string
    {
        return null;
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
