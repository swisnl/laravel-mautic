<?php

namespace Swis\Laravel\Mautic;

interface SynchronizesWithMautic
{
    public function toMauticArray(): array;

    public function mauticType(): string;

    public function getMauticId(): ?string;

    public function setMauticId(string $id): void;
}
