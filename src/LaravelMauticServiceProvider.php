<?php

namespace Swis\Laravel\Mautic;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Swis\Laravel\Mautic\Commands\LaravelMauticCommand;

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
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-mautic_table')
            ->hasCommand(LaravelMauticCommand::class);
    }
}
