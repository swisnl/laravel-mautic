<?php

namespace Swis\LaravelMautic\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Swis\LaravelMautic\LaravelMautic
 */
class LaravelMautic extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Swis\LaravelMautic\LaravelMautic::class;
    }
}
