<?php

namespace Swis\Laravel\Mautic;

use Illuminate\Database\Eloquent\Model;
use Swis\Laravel\Mautic\Jobs\DeleteModelFromMautic;
use Swis\Laravel\Mautic\Jobs\PersistModelInMautic;

trait SynchronizesWithMauticTrait
{
    public static function bootSynchronizesWithMauticTrait(): void
    {
        static::saved(function (Model $model) {
            if ($model instanceof SynchronizesWithMautic) {
                dispatch($model->getOnSavedJob());
            }
        });
        static::deleted(function (Model $model) {
            if ($model instanceof SynchronizesWithMautic) {
                dispatch($model->getOnDeletedJob());
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

    public function getOnSavedJob(): PersistModelInMautic
    {
        return new PersistModelInMautic($this);
    }

    public function getOnDeletedJob(): DeleteModelFromMautic
    {
        return new DeleteModelFromMautic($this);
    }
}
