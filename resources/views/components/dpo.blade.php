@props(['label' => null])
@php($dpo = app(\JeffersonGoncalves\LgpdRecords\RecordsManager::class)->dpo())
@if ($dpo['name'] || $dpo['email'])
    <address {{ $attributes->merge(['class' => 'lgpd-dpo']) }}>
        {{ $label ?? __('Data protection officer') }}:
        @if ($dpo['name'])<span>{{ $dpo['name'] }}</span>@endif
        @if ($dpo['email']) &middot; <a href="mailto:{{ $dpo['email'] }}">{{ $dpo['email'] }}</a>@endif
        @if ($dpo['phone']) &middot; <a href="tel:{{ preg_replace('/[^0-9+]/', '', $dpo['phone']) }}">{{ $dpo['phone'] }}</a>@endif
    </address>
@endif
