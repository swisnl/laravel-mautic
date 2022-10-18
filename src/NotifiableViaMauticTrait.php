<?php

namespace Swis\Laravel\Mautic;

trait NotifiableViaMauticTrait
{
    public function routeNotificationForMautic(): ?string
    {
        return $this->getMauticId();
    }
}
