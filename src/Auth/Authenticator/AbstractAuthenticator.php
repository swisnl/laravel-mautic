<?php

namespace Swis\Laravel\Mautic\Auth\Authenticator;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils;
use Mautic\Response;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractAuthenticator implements AuthenticatorInterface
{
    private ClientInterface $client;

    public function withHttpClient(ClientInterface $client): static
    {
        $this->client = $client;

        return $this;
    }

    abstract protected function authorizeRequest(RequestInterface $request): RequestInterface;

    public function makeRequest($url, array $parameters = [], $method = 'GET', array $settings = [])
    {
        $request = (new Request($method, $url))
            ->withAddedHeader('Accept', 'application/json');
        // TODO: file?
        if (! empty($parameters)) {
            $request = $request->withBody(Utils::streamFor(json_encode($parameters, JSON_THROW_ON_ERROR)))
                ->withAddedHeader('Content-Type', 'application/json');
        }
        // TODO: Headers
        $request = $this->authorizeRequest($request);

        $httpResponse = $this->client->sendRequest($request);

        $response = new Response((string) $httpResponse->getBody(), $this->getCurlInfo($httpResponse));

        // Handle zip file response
        if ($response->isZip()) {
            $temporaryFilePath = isset($settings['temporaryFilePath']) ? $settings['temporaryFilePath'] : sys_get_temp_dir();

            return $response->saveToFile($temporaryFilePath);
        }

        return $response->getDecodedBody();
    }

    /**
     * @param  \Psr\Http\Message\ResponseInterface  $httpResponse
     *
     * @see \curl_getinfo()
     *
     * @return array
     */
    private function getCurlInfo(ResponseInterface $httpResponse): array
    {
        return [
            'content_type' => $httpResponse->getHeader('content-type')[0],
            'http_code' => $httpResponse->getStatusCode(),
        ];
    }
}
