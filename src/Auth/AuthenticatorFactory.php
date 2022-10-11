<?php

declare(strict_types=1);

namespace Swis\Laravel\Mautic\Auth;

use InvalidArgumentException;
use Swis\Laravel\Mautic\Auth\Authenticator\AuthenticatorInterface;

class AuthenticatorFactory
{
    public function make(string $method, array $config): AuthenticatorInterface
    {
        switch ($method) {
            case 'oauth':
                return new Authenticator\OauthAuthenticator($config);
            case 'password':
                return new Authenticator\PasswordAuthenticator($config);
        }

        throw new InvalidArgumentException("Unsupported authentication method [$method].");
    }
}
