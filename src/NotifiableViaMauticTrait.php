<?php

namespace Swis\Laravel\Mautic;

/** @phpstan-ignore trait.unused */
trait NotifiableViaMauticTrait
{
    public function routeNotificationForMautic(): ?string
    {
        return $this->getMauticId();
    }
}
