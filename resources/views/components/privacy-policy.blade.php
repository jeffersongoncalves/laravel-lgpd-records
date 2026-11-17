@props(['rightsUrl' => null])
@php
    $ropa = app(\JeffersonGoncalves\LgpdRecords\RecordsManager::class)->export();
    $updatedAt = \JeffersonGoncalves\LgpdRecords\Models\ProcessingActivity::query()->max('updated_at');
    $label = fn (string $group, ?string $key): ?string => $key === null ? null
        : (\Illuminate\Support\Facades\Lang::has("lgpd-records::policy.{$group}.{$key}") ? __("lgpd-records::policy.{$group}.{$key}") : $key);
@endphp
<article {{ $attributes->merge(['class' => 'lgpd-privacy-policy']) }}>
    <h2>{{ __('lgpd-records::policy.title') }}</h2>
    @if ($updatedAt)
        <p>{{ __('lgpd-records::policy.updated_at', ['date' => \Illuminate\Support\Carbon::parse($updatedAt)->translatedFormat('d/m/Y')]) }}</p>
    @endif

    <section>
        <h3>{{ __('lgpd-records::policy.controller') }}</h3>
        @if ($ropa['controller']['name'] ?? null)
            <p>{{ __('lgpd-records::policy.controller_text', ['name' => $ropa['controller']['name']]) }}</p>
        @endif
        <ul>
            @if ($ropa['controller']['document'] ?? null)<li>{{ __('lgpd-records::policy.document') }}: {{ $ropa['controller']['document'] }}</li>@endif
            @if ($ropa['controller']['contact'] ?? null)<li>{{ __('lgpd-records::policy.contact') }}: {{ $ropa['controller']['contact'] }}</li>@endif
        </ul>
        <x-lgpd-records::dpo :label="__('lgpd-records::policy.dpo')" />
    </section>

    <section>
        <h3>{{ __('lgpd-records::policy.processing') }}</h3>
        @forelse ($ropa['activities'] as $activity)
            <section>
                <h4>{{ $activity['name'] }}</h4>
                <dl>
                    <dt>{{ __('lgpd-records::policy.purpose') }}</dt>
                    <dd>{{ $activity['purpose'] }}</dd>
                    @if ($activity['legal_basis'])
                        <dt>{{ __('lgpd-records::policy.legal_basis') }}</dt>
                        <dd>{{ $label('legal_bases', $activity['legal_basis']) }}</dd>
                    @endif
                    @if ($activity['data_categories'] !== [] || $activity['personal_data'] !== [])
                        <dt>{{ __('lgpd-records::policy.data') }}</dt>
                        <dd>{{ collect($activity['data_categories'])
                            ->merge(collect($activity['personal_data'])->map(fn (array $row): string => str_replace('_', ' ', $row['column'])
                                .($row['category'] === 'sensitive' ? ' ('.__('lgpd-records::policy.sensitive').')' : '')))
                            ->unique()->implode(', ') }}</dd>
                    @endif
                    @if ($activity['data_subjects'] !== [])
                        <dt>{{ __('lgpd-records::policy.data_subjects') }}</dt>
                        <dd>{{ implode(', ', $activity['data_subjects']) }}</dd>
                    @endif
                    @if ($activity['recipients'] !== [])
                        <dt>{{ __('lgpd-records::policy.recipients') }}</dt>
                        <dd>{{ collect($activity['recipients'])->map(fn (array $r): string => $r['name'].(isset($r['role']) ? ' ('.$label('roles', $r['role']).')' : ''))->implode(', ') }}</dd>
                    @endif
                    @if ($activity['international_transfers'] !== [])
                        <dt>{{ __('lgpd-records::policy.transfers') }}</dt>
                        <dd>{{ collect($activity['international_transfers'])->map(fn (array $t): string => $t['country'].(isset($t['mechanism']) ? ' ('.$label('mechanisms', $t['mechanism']).')' : ''))->implode(', ') }}</dd>
                    @endif
                    @if ($activity['retention'])
                        <dt>{{ __('lgpd-records::policy.retention') }}</dt>
                        <dd>{{ $activity['retention'] }}</dd>
                    @endif
                </dl>
            </section>
        @empty
            <p>{{ __('lgpd-records::policy.none') }}</p>
        @endforelse
    </section>

    <section>
        <h3>{{ __('lgpd-records::policy.rights') }}</h3>
        <p>{{ __('lgpd-records::policy.rights_intro') }}</p>
        <ul>
            @foreach ((array) __('lgpd-records::policy.rights_list') as $right)
                <li>{{ $right }}</li>
            @endforeach
        </ul>
        @if ($rightsUrl)
            <p><a href="{{ $rightsUrl }}">{{ __('lgpd-records::policy.rights_request') }}</a></p>
        @else
            <p>{{ __('lgpd-records::policy.rights_contact') }}</p>
        @endif
        <p>{{ __('lgpd-records::policy.anpd') }}</p>
    </section>
</article>
