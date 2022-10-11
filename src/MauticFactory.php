<?php

declare(strict_types=1);

namespace Swis\Laravel\Mautic;

use Illuminate\Support\Arr;
use InvalidArgumentException;
use Mautic\MauticApi;
use Swis\Laravel\Mautic\Auth\AuthenticatorFactory;

class MauticFactory
{
    public function __construct(protected AuthenticatorFactory $auth)
    {
    }

    /**
     * Make a new mautic client.
     *
     * @param  string[]  $config
     * @return \Mautic\MauticApi
     *
     * @throws \InvalidArgumentException
     */
    public function make(array $config)
    {
        $client = new MauticApi($config);

        if (! array_key_exists('method', $config)) {
            throw new InvalidArgumentException('The mautic factory requires an auth method.');
        }

        if ($url = Arr::get($config, 'url')) {
            $client->setBaseUrl($url);
        }

        // TODO: Auth

        return $client;
//        return $this->auth->make($config['method'])->with($client)->authenticate($config);
    }
}
