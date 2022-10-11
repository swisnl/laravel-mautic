<?php

namespace Swis\Laravel\Mautic\Auth\Authenticator;

use League\OAuth2\Client\Token\AccessTokenInterface;
use Psr\Http\Message\RequestInterface;
use Swis\Laravel\Mautic\Auth\OauthProvider;

class OauthAuthenticator extends AbstractAuthenticator
{
    protected OauthProvider $provider;

    protected AccessTokenInterface $accessToken;

    public function __construct(array $config)
    {
        $this->provider = new OauthProvider($config);
    }

    public function isAuthorized(): bool
    {
        return isset($this->accessToken) && ! $this->accessToken->hasExpired();
    }

    public function authorize(): void
    {
        $this->accessToken ??= $this->provider->getAccessToken('client_credentials');

        if ($this->accessToken->hasExpired()) {
            $this->accessToken = $this->provider->getAccessToken('refresh_token', [
                'refresh_token' => $this->accessToken->getRefreshToken(),
            ]);
        }
    }

    protected function authorizeRequest(RequestInterface $request): RequestInterface
    {
        $this->authorize();

        return $request->withAddedHeader('Authorization', 'Bearer '.$this->accessToken->getToken());
    }
}
