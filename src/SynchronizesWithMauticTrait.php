<?php

namespace Swis\Laravel\Mautic;

use Swis\Laravel\Mautic\Jobs\DeleteModelFromMautic;
use Swis\Laravel\Mautic\Jobs\PersistModelInMautic;

trait SynchronizesWithMauticTrait
{
    public static function bootSynchronizesWithMauticTrait(): void
    {
        static::saved(function ($model) {
            if ($model instanceof SynchronizesWithMautic) {
                PersistModelInMautic::dispatch($model);
            }
        });
        static::deleted(function ($model) {
            if ($model instanceof SynchronizesWithMautic) {
                DeleteModelFromMautic::dispatch($model);
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
