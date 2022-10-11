<?php

namespace Swis\Laravel\Mautic;

use Mautic\Api\Api;
use Mautic\Api\Assets;
use Mautic\Api\CampaignEvents;
use Mautic\Api\Campaigns;
use Mautic\Api\Categories;
use Mautic\Api\Companies;
use Mautic\Api\CompanyFields;
use Mautic\Api\Contacts;
use Mautic\Api\Data;
use Mautic\Api\Devices;
use Mautic\Api\DynamicContents;
use Mautic\Api\Emails;
use Mautic\Api\Files;
use Mautic\Api\Focus;
use Mautic\Api\Forms;
use Mautic\Api\Messages;
use Mautic\Api\Notes;
use Mautic\Api\Notifications;
use Mautic\Api\Pages;
use Mautic\Api\Points;
use Mautic\Api\PointTriggers;
use Mautic\Api\Reports;
use Mautic\Api\Roles;
use Mautic\Api\Segments;
use Mautic\Api\Smses;
use Mautic\Api\Stages;
use Mautic\Api\Stats;
use Mautic\Api\Tags;
use Mautic\Api\Themes;
use Mautic\Api\Tweets;
use Mautic\Api\Users;
use Mautic\Api\Webhooks;
use Mautic\Auth\AuthInterface;
use Mautic\Auth\BasicAuth;
use Mautic\Exception\ContextNotFoundException;
use Mautic\MauticApi;

/**
 * @method Assets assets()
 * @method CampaignEvents campaignEvents()
 * @method Campaigns campaigns()
 * @method Categories categories()
 * @method Companies companies()
 * @method CompanyFields companyFields()
 * @method Contacts contacts()
 * @method Data data()
 * @method Devices devices()
 * @method DynamicContents dynamicContents()
 * @method Emails emails()
 * @method Files files()
 * @method Focus focus()
 * @method Forms forms()
 * @method Messages messages()
 * @method Notes notes()
 * @method Notifications notifications()
 * @method Pages pages()
 * @method Points points()
 * @method PointTriggers pointTriggers()
 * @method Reports reports()
 * @method Roles roles()
 * @method Segments segments()
 * @method Smses smses()
 * @method Stages stages()
 * @method Stats stats()
 * @method Tags tags()
 * @method Themes themes()
 * @method Tweets tweets()
 * @method Users users()
 * @method Webhooks webhooks()
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
