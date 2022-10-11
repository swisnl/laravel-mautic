<?php

declare(strict_types=1);

namespace Swis\Laravel\Mautic;

use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;

/**
 * This is the mautic manager class.
 *
 * @method \Mautic\MauticApi                              connection(string|null $name = null)
 * @method \Mautic\MauticApi                              reconnect(string|null $name = null)
 * @method void                                           disconnect(string|null $name = null)
 * @method array<string,\Mautic\MauticApi>                getConnections()
 * @method void                                           authenticate(string $method, string $token, string|null $password = null)
 * @method void                                           setUrl(string $url)
 */
class MauticManager extends AbstractManager
{
    protected MauticFactory $factory;

    /**
     * Create a new mautic manager instance.
     *
     * @param  \Illuminate\Contracts\Config\Repository  $config
     * @param  \Swis\Laravel\Mautic\MauticFactory  $factory
     */
    public function __construct(Repository $config, MauticFactory $factory)
    {
        parent::__construct($config);
        $this->factory = $factory;
    }

    /**
     * Create the connection instance.
     *
     * @param  array  $config
     * @return \Mautic\MauticApi
     */
    protected function createConnection(array $config)
    {
        return $this->factory->make($config);
    }

    /**
     * Get the configuration name.
     *
     * @return string
     */
    protected function getConfigName(): string
    {
        return 'mautic';
    }


    /**
     * Get the factory
     * @return MauticFactory
     */
    public function getFactory(): MauticFactory
    {
        return $this->factory;
    }
}
