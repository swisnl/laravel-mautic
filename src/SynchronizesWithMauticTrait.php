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
                $job = $model->getOnSavedJob();

                if ($job !== null) {
                    dispatch($job);
                }
            }
        });
        static::deleted(function (Model $model) {
            if ($model instanceof SynchronizesWithMautic) {
                $job = $model->getOnDeletedJob();

                if ($job !== null) {
                    dispatch($job);
                }
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

    public function getOnDeletedJob(): ?DeleteModelFromMautic
    {
        if (!$this->getMauticId()) {
            return null;
        }

        return new DeleteModelFromMautic(
            $this->getMauticId(),
            $this->getMauticType(),
            $this->getMauticConnection()
        );
    }
}
