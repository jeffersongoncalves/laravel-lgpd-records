<?php

namespace JeffersonGoncalves\LgpdRecords\Models;

use Illuminate\Database\Eloquent\Model;
use JeffersonGoncalves\Lgpd\Enums\LegalBasis;

/**
 * One processing operation of the controller (art. 37).
 *
 * @property string $name
 * @property string $purpose
 * @property LegalBasis|null $legal_basis
 * @property list<string>|null $data_subjects e.g. customers, employees, visitors
 * @property list<string>|null $data_categories free text, beside the declared columns of $models
 * @property list<class-string>|null $models
 * @property list<array{name: string, role?: string, country?: string}>|null $recipients role: processor, controller, public_authority
 * @property list<array{country: string, mechanism?: string}>|null $international_transfers mechanism: one of art. 33
 * @property string|null $retention
 * @property string|null $security_measures
 */
class ProcessingActivity extends Model
{
    protected $guarded = [];

    public function getTable(): string
    {
        return config('lgpd-records.table', 'lgpd_processing_activities');
    }

    protected function casts(): array
    {
        return [
            'legal_basis' => LegalBasis::class,
            'data_subjects' => 'array',
            'data_categories' => 'array',
            'models' => 'array',
            'recipients' => 'array',
            'international_transfers' => 'array',
        ];
    }
}
