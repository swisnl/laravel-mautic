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

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-mautic-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-mautic-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-mautic-views"
```

## Usage

```php
$laravelMautic = new Swis\Laravel\Mautic\Client();
echo $laravelMautic->echoPhrase('Hello, Swis!');
```

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

- [Jasper Zonneveld](https://github.com/JaZo)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
