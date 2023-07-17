<?php

namespace Swis\Laravel\Mautic\Auth\Authenticator;

use League\OAuth2\Client\Token\AccessTokenInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Swis\Laravel\Mautic\Auth\OauthProvider;
use Swis\Laravel\Mautic\Support\Psr18GuzzleAdapter;

class OauthAuthenticator extends AbstractAuthenticator
{
    protected OauthProvider $provider;

    protected AccessTokenInterface $accessToken;

    public function __construct(ClientInterface $client, array $config)
    {
        parent::__construct($client);
        $this->provider = new OauthProvider($config, ['httpClient' => new Psr18GuzzleAdapter($this->client)]);
    }

    public function isAuthorized(): bool
    {
        return isset($this->accessToken) && ! $this->accessToken->hasExpired();
    }

    public function authorize(): void
    {
        $this->accessToken ??= $this->provider->getAccessToken('client_credentials');

        if ($this->accessToken->hasExpired()) {
            $this->accessToken = $this->provider->getAccessToken('client_credentials');
        }
    }

    protected function authorizeRequest(RequestInterface $request): RequestInterface
    {
        $this->authorize();

        return $request->withAddedHeader('Authorization', 'Bearer '.$this->accessToken->getToken());
    }
}
