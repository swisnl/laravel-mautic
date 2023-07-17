<?php

namespace Swis\Laravel\Mautic\Auth\Authenticator;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;

class PasswordAuthenticator extends AbstractAuthenticator
{
    protected string $username;

    protected string $password;

    public function __construct(ClientInterface $client, array $config)
    {
        parent::__construct($client);
        $this->username = $config['username'];
        $this->password = $config['password'];
    }

    public function isAuthorized(): bool
    {
        return isset($this->username, $this->password);
    }

    protected function authorizeRequest(RequestInterface $request): RequestInterface
    {
        return $request->withAddedHeader('Authorization', 'Basic '.base64_encode($this->username.':'.$this->password));
    }
}
