<?php

namespace JeffersonGoncalves\LgpdRecords;

use JeffersonGoncalves\LgpdRecords\Commands\RopaCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LgpdRecordsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('lgpd-records')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations(['create_lgpd_processing_activities_table'])
            ->hasCommand(RopaCommand::class);
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(RecordsManager::class);
    }
}
