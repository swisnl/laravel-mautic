<?php

namespace Swis\Laravel\Mautic\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Swis\Laravel\Mautic\MauticManager
 */
class Mautic extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-mautic';
    }
}
