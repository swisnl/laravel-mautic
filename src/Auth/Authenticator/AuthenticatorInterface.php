<?php

namespace Swis\Laravel\Mautic\Auth\Authenticator;

use Mautic\Auth\AuthInterface;
use Psr\Http\Client\ClientInterface;

interface AuthenticatorInterface extends AuthInterface
{
    public function withHttpClient(ClientInterface $client): static;
}
