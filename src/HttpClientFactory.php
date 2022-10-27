<?php

namespace Swis\Laravel\Mautic;

use GuzzleHttp\Client as HttpClient;
use Psr\Http\Client\ClientInterface;

class HttpClientFactory
{
    public function make(array $config): ClientInterface
    {
        return new HttpClient();
    }
}
