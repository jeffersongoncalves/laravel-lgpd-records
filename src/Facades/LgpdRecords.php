<?php

namespace JeffersonGoncalves\LgpdRecords\Facades;

use Illuminate\Support\Facades\Facade;
use JeffersonGoncalves\LgpdRecords\RecordsManager;

/**
 * @method static array{controller: array<string, mixed>, dpo: array<string, mixed>, activities: list<array<string, mixed>>} export()
 * @method static array{name: string|null, email: string|null, phone: string|null} dpo()
 *
 * @see RecordsManager
 */
class LgpdRecords extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RecordsManager::class;
    }
}
