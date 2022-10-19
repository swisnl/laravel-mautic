<?php

use Swis\Laravel\Mautic\Client;
use Swis\Laravel\Mautic\Facades\Mautic;
use Swis\Laravel\Mautic\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

function mockManager(string $methodName, $api): void
{
    $clientMock = mock(Client::class)
        ->makePartial()
        ->shouldReceive($methodName)
        ->andReturn($api)
        ->getMock();

    Mautic::partialMock()
        ->shouldReceive('connection')
        ->andReturn($clientMock);
}
