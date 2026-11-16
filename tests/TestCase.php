<?php

namespace JeffersonGoncalves\LgpdRecords\Tests;

use JeffersonGoncalves\LgpdRecords\LgpdRecordsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LgpdRecordsServiceProvider::class,
        ];
    }
}
