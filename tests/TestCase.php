<?php

namespace JeffersonGoncalves\LgpdRecords\Tests;

use JeffersonGoncalves\Lgpd\LgpdServiceProvider;
use JeffersonGoncalves\LgpdRecords\LgpdRecordsServiceProvider;
use JeffersonGoncalves\LgpdRecords\Tests\Fixtures\Customer;
use JeffersonGoncalves\PestPluginDatabaseMigrations\LoadsPackageMigrations;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use LoadsPackageMigrations;

    protected function getPackageProviders($app): array
    {
        return [
            LgpdServiceProvider::class,
            LgpdRecordsServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('lgpd.models', [Customer::class]);
        $app['config']->set('lgpd-records.controller.name', 'Acme Ltda');
        $app['config']->set('lgpd-records.dpo', ['name' => 'Ana Souza', 'email' => 'dpo@acme.test', 'phone' => '+55 (11) 4000-0000']);
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadPackageMigrations(LgpdRecordsServiceProvider::class);
    }
}
