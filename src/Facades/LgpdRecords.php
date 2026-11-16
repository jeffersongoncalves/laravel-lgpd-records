<?php

namespace JeffersonGoncalves\LgpdRecords\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JeffersonGoncalves\LgpdRecords\LgpdRecords
 */
class LgpdRecords extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-lgpd-records';
    }
}
