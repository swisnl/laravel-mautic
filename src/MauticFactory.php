<?php

declare(strict_types=1);

namespace Swis\Laravel\Mautic;

use Swis\Laravel\Mautic\Auth\AuthenticatorFactory;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Mautic\MauticApi;

class MauticFactory
{
    public function __construct(protected AuthenticatorFactory $auth)
    {
    }

    /**
     * Make a new mautic client.
     *
     * @param string[] $config
     *
     * @throws \InvalidArgumentException
     *
     * @return \Mautic\MauticApi
     */
    public function make(array $config)
    {
        $client = new MauticApi($config);

        if (!array_key_exists('method', $config)) {
            throw new InvalidArgumentException('The mautic factory requires an auth method.');
        }

        if ($url = Arr::get($config, 'url')) {
            $client->setUrl($url);
        }

        // TODO: Auth

        return $this->auth->make($config['method'])->with($client)->authenticate($config);
    }
}
