<?php

namespace Swis\Laravel\Mautic;

use Illuminate\Container\Container;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Swis\Laravel\Mautic\Auth\AuthenticatorFactory;

class LaravelMauticServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-mautic')
            ->hasConfigFile();

        $this->registerHttpClientFactory();
        $this->registerAuthFactory();
        $this->registerFactory();
        $this->registerMautic();
    }

    protected function registerHttpClientFactory(): void
    {
        $this->app->singleton('laravel-mautic.httpclientfactory', function () {
            return new HttpClientFactory;
        });
        $this->app->alias('laravel-mautic.httpclientfactory', HttpClientFactory::class);
    }

    protected function registerAuthFactory(): void
    {
        $this->app->singleton('laravel-mautic.authfactory', function (Container $app) {
            $httpClientFactory = $app['laravel-mautic.httpclientfactory'];

            return new AuthenticatorFactory($httpClientFactory);
        });
        $this->app->alias('laravel-mautic.authfactory', AuthenticatorFactory::class);
    }

    protected function registerFactory(): void
    {
        $this->app->singleton('laravel-mautic.factory', function (Container $app) {
            $authFactory = $app['laravel-mautic.authfactory'];

            return new MauticFactory($authFactory);
        });
        $this->app->alias('laravel-mautic.factory', MauticFactory::class);
    }

    protected function registerMautic(): void
    {
        $this->app->singleton('laravel-mautic', function (Container $app) {
            $config = $app['config'];
            $factory = $app['laravel-mautic.factory'];

            return new MauticManager($config, $factory);
        });

        $this->app->alias('laravel-mautic', MauticManager::class);
    }
}
