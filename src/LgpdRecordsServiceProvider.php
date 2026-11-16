<?php

namespace JeffersonGoncalves\LgpdRecords;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LgpdRecordsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-lgpd-records')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations();
    }
}
