# Laravel wrapper for Mautic API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/swisnl/laravel-mautic.svg?style=flat-square)](https://packagist.org/packages/swisnl/laravel-mautic)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/swisnl/laravel-mautic/run-tests?label=tests)](https://github.com/swisnl/laravel-mautic/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/swisnl/laravel-mautic/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/swisnl/laravel-mautic/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/swisnl/laravel-mautic.svg?style=flat-square)](https://packagist.org/packages/swisnl/laravel-mautic)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

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

This option (`'connections'`) is where each of the connections are setup for your application. Example configuration has been included, but you may add as many connections as you would like. Note that the 2 supported authentication methods are: `"oauth"` and `"password"`.

## Usage

##### MauticManager

This is the class of most interest. It is bound to the ioc container as `'laravel-mautic'` and can be accessed using the `Facades\Mautic` facade. This class implements the `ManagerInterface` by extending `AbstractManager`. The interface and abstract class are both part of my [Laravel Manager](https://github.com/GrahamCampbell/Laravel-Manager) package, so you may want to go and checkout the docs for how to use the manager class over at [that repo](https://github.com/GrahamCampbell/Laravel-Manager#usage). Note that the connection class returned will always be an instance of `Swis\Laravel\Mautic\Client`.

##### Facades\Mautic

This facade will dynamically pass static method calls to the `'laravel-mautic'` object in the ioc container which by default is the `MauticManager` class.

##### LaravelMauticServiceProvider

This class contains no public methods of interest. This class should be added to the providers array in `config/app.php`. This class will setup ioc bindings.

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

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Anthony Schuijlenburg](https://github.com/AnthonySchuijlenburg)
- [Jasper Zonneveld](https://github.com/JaZo)
- [Rien van Velzen](https://github.com/Rocksheep)
- [Thomas Wijnands](https://github.com/tommie1001)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
