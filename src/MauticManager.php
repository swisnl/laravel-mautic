<?php

declare(strict_types=1);

namespace Swis\Laravel\Mautic;

use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;

/**
 * @method \Swis\Laravel\Mautic\Client                    connection(string|null $name = null)
 * @method \Swis\Laravel\Mautic\Client                    reconnect(string|null $name = null)
 * @method void                                           disconnect(string|null $name = null)
 * @method array<string,\Swis\Laravel\Mautic\Client>      getConnections()
 */
class MauticManager extends AbstractManager
{
    protected MauticFactory $factory;

    public function __construct(Repository $config, MauticFactory $factory)
    {
        parent::__construct($config);
        $this->factory = $factory;
    }

    protected function createConnection(array $config): Client
    {
        return $this->factory->make($config);
    }

    protected function getConfigName(): string
    {
        return 'mautic';
    }

    public function getFactory(): MauticFactory
    {
        return $this->factory;
    }
}
