<?php

namespace Swis\Laravel\Mautic\Auth\Authenticator;

use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Support\Str;
use Mautic\Response;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;

abstract class AbstractAuthenticator implements AuthenticatorInterface
{
    public function __construct(protected ClientInterface $client) {}

    abstract protected function authorizeRequest(RequestInterface $request): RequestInterface;

    public function makeRequest($url, array $parameters = [], $method = 'GET', array $settings = [])
    {
        [$url, $parameters] = $this->separateUrlParams($url, $parameters);

        // Make sure $method is capitalized for congruency
        $method = strtoupper($method);
        $headers = (isset($settings['headers']) && is_array($settings['headers'])) ? $settings['headers'] : [];

        // Prepare parameters/body
        $body = null;
        $contentType = null;
        if (in_array($method, ['POST', 'PUT', 'PATCH'])) {
            if (! empty($parameters['file']) && file_exists($parameters['file'])) {
                $elements = [];
                foreach ($parameters as $key => $value) {
                    $elements[] = [
                        'name' => $key,
                        'contents' => $key === 'file' ? Utils::tryFopen($value, 'r+') : $value,
                    ];
                }

                $body = new MultipartStream($elements);
                $contentType = 'multipart/form-data; boundary='.$body->getBoundary();
            } else {
                $body = Utils::streamFor(json_encode($parameters, JSON_THROW_ON_ERROR));
                $contentType = 'application/json';
            }
        } elseif (! empty($parameters)) {
            $url .= '?'.http_build_query($parameters, '', '&');
        }

        // Build request
        $request = new Request($method, $url);
        foreach ($headers as $header) {
            $request = $request->withAddedHeader(Str::before($header, ':'), trim(Str::after($header, ':')));
        }
        $request = $request->withHeader('Accept', 'application/json');
        if ($body) {
            $request = $request->withBody($body);
            if ($contentType) {
                $request = $request->withHeader('Content-Type', $contentType);
            }
        }
        $request = $this->authorizeRequest($request);

        // Send request
        $httpResponse = $this->client->sendRequest($request);

        // Parse response
        $response = new Response($httpResponse);

        // Handle zip file response
        if ($response->isZip()) {
            return $response->saveToFile($settings['temporaryFilePath'] ?? sys_get_temp_dir());
        }

        return $response->getDecodedBody();
    }

    /**
     * Separates parameters from base URL.
     *
     * @return array{string, array}
     */
    protected function separateUrlParams(string $url, array $params): array
    {
        $query = parse_url($url, PHP_URL_QUERY);
        if (! empty($query)) {
            parse_str($query, $queryParts);
            $cleanParams = [];
            foreach ($queryParts as $key => $value) {
                $cleanParams[$key] = $value ?: '';
            }
            $params = array_merge($params, $cleanParams);
            $url = Str::before($url, '?');
        }

        return [$url, $params];
    }
}
