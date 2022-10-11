<?php

declare(strict_types=1);

// config for swisnl/laravel-mautic
return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Mautic Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like. Note that the 2 supported authentication methods are:
    | "oauth" and "password".
    |
    */

    'connections' => [

        'main' => [
            'method' => 'oauth',
            'clientId' => 'key',
            'clientSecret' => 'secret',
            'url' => 'https://your-mautic-instance.com',
        ],

        'alternative' => [
            'method' => 'password',
            'username' => 'foo',
            'password' => 'bar',
            'url' => 'https://your-mautic-instance.com',
        ],

    ],

];
