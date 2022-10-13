<?php

namespace Swis\Laravel\Mautic;

interface SynchronizesWithMautic
{
    public function toMauticArray(): array;

    public function getMauticType(): string;

    public function getMauticConnection(): ?string;

    public function getMauticId(): ?string;

    public function setMauticId(string $id): void;
}
