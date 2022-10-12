<?php

namespace Swis\Laravel\Mautic\Facades;

use Illuminate\Support\Facades\Facade;
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
use Swis\Laravel\Mautic\Client;

/**
 * @see \Swis\Laravel\Mautic\MauticManager
 * @mixin Client
 *
 * @method static Assets assets()
 * @method static CampaignEvents campaignEvents()
 * @method static Campaigns campaigns()
 * @method static Categories categories()
 * @method static Companies companies()
 * @method static CompanyFields companyFields()
 * @method static Contacts contacts()
 * @method static Data data()
 * @method static Devices devices()
 * @method static DynamicContents dynamicContents()
 * @method static Emails emails()
 * @method static Files files()
 * @method static Focus focus()
 * @method static Forms forms()
 * @method static Messages messages()
 * @method static Notes notes()
 * @method static Notifications notifications()
 * @method static Pages pages()
 * @method static Points points()
 * @method static PointTriggers pointTriggers()
 * @method static Reports reports()
 * @method static Roles roles()
 * @method static Segments segments()
 * @method static Smses smses()
 * @method static Stages stages()
 * @method static Stats stats()
 * @method static Tags tags()
 * @method static Themes themes()
 * @method static Tweets tweets()
 * @method static Users users()
 * @method static Webhooks webhooks()
 * @method static self connection(?string $name)
 */
class Mautic extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-mautic';
    }
}
