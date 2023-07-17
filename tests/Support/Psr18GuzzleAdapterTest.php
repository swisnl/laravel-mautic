<?php

namespace Swis\Laravel\Mautic\Tests\Support;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Swis\Laravel\Mautic\Support\NotImplementedException;
use Swis\Laravel\Mautic\Support\Psr18GuzzleAdapter;

test('send is implemented', function () {
    $request = mock(RequestInterface::class);

    $client = mock(ClientInterface::class);
    $client->shouldReceive('sendRequest')
        ->once()
        ->with($request)
        ->andReturn(mock(ResponseInterface::class));

    $adapter = new Psr18GuzzleAdapter($client);

    $adapter->send($request);
});

test('send async is not implemented', function () {
    $adapter = new Psr18GuzzleAdapter(mock(ClientInterface::class));

    $this->expectException(NotImplementedException::class);
    $this->expectExceptionMessage('::sendAsync() is not implemented.');

    $adapter->sendAsync(mock(RequestInterface::class));
});

test('request is not implemented', function () {
    $adapter = new Psr18GuzzleAdapter(mock(ClientInterface::class));

    $this->expectException(NotImplementedException::class);
    $this->expectExceptionMessage('::request() is not implemented.');

    $adapter->request('GET', '');
});

test('request async is not implemented', function () {
    $adapter = new Psr18GuzzleAdapter(mock(ClientInterface::class));

    $this->expectException(NotImplementedException::class);
    $this->expectExceptionMessage('::requestAsync() is not implemented.');

    $adapter->requestAsync('GET', '');
});

test('get config is not implemented', function () {
    $adapter = new Psr18GuzzleAdapter(mock(ClientInterface::class));

    $this->expectException(NotImplementedException::class);
    $this->expectExceptionMessage('::getConfig() is not implemented.');

    $adapter->getConfig();
});
