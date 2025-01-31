<?php

declare(strict_types=1);

namespace Swis\Laravel\Mautic\Auth;

use InvalidArgumentException;
use Swis\Laravel\Mautic\Auth\Authenticator\AuthenticatorInterface;
use Swis\Laravel\Mautic\HttpClientFactory;

class AuthenticatorFactory
{
    public function __construct(protected HttpClientFactory $httpClientFactory) {}

    public function make(string $method, array $config): AuthenticatorInterface
    {
        switch ($method) {
            case 'oauth':
                return new Authenticator\OauthAuthenticator($this->httpClientFactory->make($config), $config);
            case 'password':
                return new Authenticator\PasswordAuthenticator($this->httpClientFactory->make($config), $config);
        }

        throw new InvalidArgumentException("Unsupported authentication method [$method].");
    }
}
