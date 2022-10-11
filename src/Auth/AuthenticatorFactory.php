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
     * @return Authenticator\PasswordAuthenticator
     *
     * @throws \InvalidArgumentException
     */
    public function make(string $method): Authenticator\PasswordAuthenticator
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
