# Laravel wrapper for Mautic API

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Buy us a tree][ico-treeware]][link-treeware]
[![GitHub Tests Action Status][ico-tests]][link-tests]
[![GitHub Code Style Action Status][ico-code-style]][link-code-style]
[![Total Downloads][ico-downloads]][link-downloads]
[![Made by SWIS][ico-swis]][link-swis]

A batteries included Laravel wrapper for Mautic API. 

## Installation

You can install the package via composer:

```bash
composer require swisnl/laravel-mautic
```

## Configuration

Laravel Mautic requires connection configuration.

To get started, you'll need to publish all vendor assets:

```bash
php artisan vendor:publish --tag="mautic-config"
```

This will create a `config/mautic.php` file in your app that you can modify to set your configuration. Also, make sure you check for changes to the original config file in this package between releases.

There are two config options:

##### Default Connection Name

This option (`'default'`) is where you may specify which of the connections below you wish to use as your default connection for all work. Of course, you may use many connections at once using the manager class. The default value for this setting is `'main'`.

##### Mautic Connections

This option (`'connections'`) is where each of the connections are set up for your application. Example configuration has been included, but you may add as many connections as you would like. Note that the 2 supported authentication methods are: `"oauth"` and `"password"`.

## Usage

##### MauticManager

This is the class of most interest. It is bound to the ioc container as `'laravel-mautic'` and can be accessed using the `Facades\Mautic` facade. This class implements the `ManagerInterface` by extending `AbstractManager`. The interface and abstract class are both part of my [Laravel Manager](https://github.com/GrahamCampbell/Laravel-Manager) package, so you may want to go and checkout the docs for how to use the manager class over at [that repo](https://github.com/GrahamCampbell/Laravel-Manager#usage). Note that the connection class returned will always be an instance of `Swis\Laravel\Mautic\Client`.

##### Facades\Mautic

This facade will dynamically pass static method calls to the `'laravel-mautic'` object in the ioc container which by default is the `MauticManager` class.

##### LaravelMauticServiceProvider

This class contains no public methods of interest. This class should be added to the providers array in `config/app.php`. This class will set up ioc bindings.

##### Real Examples

Here you can see an example of just how simple this package is to use. Out of the box, the default adapter is `main`. After you enter your authentication details in the config file, it will just work:

```php
use Swis\Laravel\Mautic\Facades\Mautic;
// you can alias this in config/app.php if you like

Mautic::contacts()->find(1);
// we're done here - how easy was that, it just works!
```

The mautic manager will behave like it is a `Swis\Laravel\Mautic\Client` class. If you want to call specific connections, you can do with the `connection` method:

```php
use Swis\Laravel\Mautic\Facades\Mautic;

// writing this:
Mautic::connection('main')->contacts()->find(1);

// is identical to writing this:
Mautic::contacts()->find(1);

// and is also identical to writing this:
Mautic::connection()->contacts()->find(1);

// this is because the main connection is configured to be the default
Mautic::getDefaultConnection(); // this will return main

// we can change the default connection
Mautic::setDefaultConnection('alternative'); // the default is now alternative

// Get all the contacts
Mautic::contacts()->getList();
```

If you prefer to use dependency injection over facades like me, then you can easily inject the manager like so:

```php
use Illuminate\Support\Facades\App; // you probably have this aliased already
use Swis\Laravel\Mautic\MauticManager;

class Foo
{
    protected $mautic;

    public function __construct(MauticManager $mautic)
    {
        $this->mautic = $mautic;
    }

    public function bar()
    {
        $this->mautic->contacts()->find(1);
    }
}

App::make('Foo')->bar();
```

For more information on what features are available on the `Swis\Laravel\Mautic\Client` class, check out the Mautic docs at [https://developer.mautic.org/#endpoints](https://developer.mautic.org/#endpoints), and the manager class at [https://github.com/GrahamCampbell/Laravel-Manager#usage](https://github.com/GrahamCampbell/Laravel-Manager#usage).

#### Notifications

To use the notification driver built into this package make sure the entity you want to notify has the following traits:

```php
class User extends Model
{
    use Notifiable;
    use SynchronizesWithMauticTrait;
    use NotifiableViaMauticTrait;
}
```

Then make sure to add a Notification to your Laravel project. This notification should include the `MauticChannel` from this package in the `via()` method. Make sure your notification includes a `toMautic()` method which returns an instance of `MauticMessage`. For this you can use the `create()` method:

```php
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Swis\Laravel\Mautic\Notifications\MauticChannel;
use Swis\Laravel\Mautic\Notifications\MauticMessage;

class OrderFulfilled extends Notification
{
    use Queueable;

    public function __construct(
        public readonly string $message,
    ) {
    }

    public function via(mixed $notifiable): array
    {
        return [MauticChannel::class];
    }

    public function toMautic(mixed $notifiable): MauticMessage
    {
        return MauticMessage::create(1) // The id of the mail in Mautic
            ->tokens([
                'message' => $message,
            ])
            ->to($mauticUserId); // Optional
    }
}
```

In this example we set Tokens and To on the `MauticMessage`. Tokens are used to add placeholders in a Mautic mail template. To is optional and will use `$notifiable->routeNotificationFor('mautic')` as fallback.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email security@swis.nl instead of using the issue tracker.

## Credits

- [Anthony Schuijlenburg](https://github.com/AnthonySchuijlenburg)
- [Jasper Zonneveld](https://github.com/JaZo)
- [Rien van Velzen](https://github.com/Rocksheep)
- [Thomas Wijnands](https://github.com/tommie1001)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

This package is [Treeware](https://treeware.earth). If you use it in production, then we ask that you [**buy the world a tree**][link-treeware] to thank us for our work. By contributing to the Treeware forest you’ll be creating employment for local families and restoring wildlife habitats.

## SWIS :heart: Open Source

[SWIS][link-swis] is a web agency from Leiden, the Netherlands. We love working with open source software.

[ico-version]: https://img.shields.io/packagist/v/swisnl/laravel-mautic.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-treeware]: https://img.shields.io/badge/Treeware-%F0%9F%8C%B3-lightgreen.svg?style=flat-square
[ico-tests]: https://img.shields.io/github/actions/workflow/status/swisnl/laravel-mautic/run-tests.yml?branch=main&label=tests&style=flat-square
[ico-code-style]: https://img.shields.io/github/actions/workflow/status/swisnl/laravel-mautic/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/swisnl/laravel-mautic.svg?style=flat-square
[ico-swis]: https://img.shields.io/badge/%F0%9F%9A%80-made%20by%20SWIS-%230737A9.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/swisnl/laravel-mautic
[link-tests]: https://github.com/swisnl/laravel-mautic/actions/workflows/run-tests.yml?query=branch%3Amain
[link-code-style]: https://github.com/swisnl/laravel-mautic/actions/workflows/fix-php-code-style-issues.yml?query=branch%3Amain
[link-downloads]: https://packagist.org/packages/swisnl/laravel-mautic
[link-treeware]: https://plant.treeware.earth/swisnl/laravel-mautic
[link-swis]: https://www.swis.nl
