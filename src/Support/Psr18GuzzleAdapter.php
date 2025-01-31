<?php

namespace Swis\Laravel\Mautic\Support;

use GuzzleHttp\ClientInterface as GuzzleHttpClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
final class Psr18GuzzleAdapter implements GuzzleHttpClientInterface
{
    public function __construct(private readonly ClientInterface $client) {}

    public function send(RequestInterface $request, array $options = []): ResponseInterface
    {
        return $this->client->sendRequest($request);
    }

    public function sendAsync(RequestInterface $request, array $options = []): PromiseInterface
    {
        throw new NotImplementedException(__METHOD__.'() is not implemented.');
    }

    public function request(string $method, $uri, array $options = []): ResponseInterface
    {
        throw new NotImplementedException(__METHOD__.'() is not implemented.');
    }

    public function requestAsync(string $method, $uri, array $options = []): PromiseInterface
    {
        throw new NotImplementedException(__METHOD__.'() is not implemented.');
    }

    public function getConfig(?string $option = null): void
    {
        throw new NotImplementedException(__METHOD__.'() is not implemented.');
    }
}
