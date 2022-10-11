<?php

declare(strict_types=1);

namespace Swis\Laravel\Mautic;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Swis\Laravel\Mautic\Auth\AuthenticatorFactory;

class MauticFactory
{
    public function __construct(protected AuthenticatorFactory $auth)
    {
    }

    /**
     * Make a new mautic client.
     *
     * @param  array<string, mixed>  $config
     * @return Client
     *
     * @throws \InvalidArgumentException
     */
    public function make(array $config): Client
    {
        $client = new Client();

        if (! array_key_exists('method', $config)) {
            throw new InvalidArgumentException('The mautic factory requires an auth method.');
        }

        if ($url = Arr::get($config, 'url')) {
            $client->setBaseUrl($url);
        }

        $client->setAuth(
            $this->auth->make($config['method'], $config)
                ->withHttpClient(new HttpClient())
        );

        return $client;
    }
}
