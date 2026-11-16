<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Blade;
use JeffersonGoncalves\Lgpd\Enums\LegalBasis;
use JeffersonGoncalves\LgpdRecords\Facades\LgpdRecords;
use JeffersonGoncalves\LgpdRecords\Models\ProcessingActivity;
use JeffersonGoncalves\LgpdRecords\Tests\Fixtures\Customer;

function billing(): ProcessingActivity
{
    return ProcessingActivity::create([
        'name' => 'Billing',
        'purpose' => 'Issue invoices',
        'legal_basis' => LegalBasis::Contract,
        'data_subjects' => ['customers'],
        'models' => [Customer::class],
        'recipients' => [['name' => 'Stripe', 'role' => 'processor', 'country' => 'US']],
        'international_transfers' => [['country' => 'US', 'mechanism' => 'standard_clauses']],
        'retention' => '5 years',
    ]);
}

it('exports the records joined with the declared personal data', function () {
    billing();

    $ropa = LgpdRecords::export();

    expect($ropa['controller']['name'])->toBe('Acme Ltda')
        ->and($ropa['dpo']['email'])->toBe('dpo@acme.test')
        ->and($ropa['activities'][0])
        ->name->toBe('Billing')
        ->legal_basis->toBe('contract')
        ->personal_data->toBe([
            ['table' => 'customers', 'column' => 'email', 'category' => 'personal', 'retention' => '5 years'],
            ['table' => 'customers', 'column' => 'tax_id', 'category' => 'personal', 'retention' => null],
        ])
        ->international_transfers->toBe([['country' => 'US', 'mechanism' => 'standard_clauses']]);
});

it('prints the records as a table or JSON', function () {
    billing();

    Artisan::call('lgpd:ropa');
    expect(Artisan::output())->toContain('Billing')->toContain('customers.email')->toContain('Stripe');

    Artisan::call('lgpd:ropa', ['--json' => true]);
    expect(json_decode(Artisan::output(), true)['activities'][0]['name'])->toBe('Billing');
});

it('warns when the DPO contact is missing', function () {
    config()->set('lgpd-records.dpo', []);

    Artisan::call('lgpd:ropa');

    expect(Artisan::output())->toContain('No data protection officer contact');
});

it('renders the public DPO contact', function () {
    $html = Blade::render('<x-lgpd-records::dpo class="footer" />');

    expect($html)->toContain('Ana Souza')
        ->toContain('mailto:dpo@acme.test')
        ->toContain('tel:+551140000000')
        ->toContain('class="lgpd-dpo footer"')
        ->and(Blade::render('<x-lgpd-records::dpo label="Encarregado" />'))->toContain('Encarregado:');

    config()->set('lgpd-records.dpo', []);

    expect(trim(Blade::render('<x-lgpd-records::dpo />')))->toBe('');
});
