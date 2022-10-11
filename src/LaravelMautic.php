<?php

namespace Swis\Laravel\Mautic;

use Mautic\Api\Api;
use Mautic\Auth\AuthInterface;
use Mautic\Auth\BasicAuth;
use Mautic\Exception\ContextNotFoundException;
use Mautic\MauticApi;

/**
 * @method assets()
 * @method campaignEvents()
 * @method campaigns()
 * @method categories()
 * @method companies()
 * @method companyFields()
 * @method contacts()
 * @method data()
 * @method devices()
 * @method dynamicContents()
 * @method emails()
 * @method files()
 * @method focus()
 * @method forms()
 * @method messages()
 * @method notes()
 * @method notifications()
 * @method pages()
 * @method points()
 * @method pointTriggers()
 * @method reports()
 * @method roles()
 * @method segments()
 * @method smses()
 * @method stages()
 * @method stats()
 * @method tags()
 * @method themes()
 * @method tweets()
 * @method users()
 * @method webhooks()
 */
class LaravelMautic extends MauticApi
{
    protected string $baseUrl;

    public function setBaseUrl(string $baseUrl): self
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    public function newApi($apiContext, AuthInterface $auth, $baseUrl = ''): Api
    {
        return parent::newApi($apiContext, $auth, empty($baseUrl) ? $this->baseUrl : $baseUrl);
    }

    /**
     * @throws ContextNotFoundException
     */
    public function __call(string $name, array $arguments)
    {
        return $this->newApi($name, $this->getAuth());
    }

    private function getAuth(): AuthInterface
    {
        $auth = new BasicAuth();

        return $auth;
    }
}
