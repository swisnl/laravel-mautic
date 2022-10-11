<?php

declare(strict_types=1);

namespace Swis\Laravel\Mautic\Auth;

use InvalidArgumentException;

class AuthenticatorFactory
{
    /**
     * Make a new authenticator instance.
     *
     * @param  string  $method
     * @return \Swis\Laravel\Mautic\Auth\Authenticator\AuthenticatorInterface
     *
     * @throws \InvalidArgumentException
     */
    public function make(string $method)
    {
        switch ($method) {
            case 'oauth':
                return new Authenticator\OauthAuthenticator();
            case 'password':
                return new Authenticator\PasswordAuthenticator();
        }

        throw new InvalidArgumentException("Unsupported authentication method [$method].");
    }
}
