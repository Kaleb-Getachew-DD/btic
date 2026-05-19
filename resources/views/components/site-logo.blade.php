@props(['variant' => 'navbar'])

@php
    $logoUrl = \App\Models\Setting::assetUrl('site_logo');
    $siteName = \App\Models\Setting::get('site_name', 'DDU BTIC');
    $boxClass = match ($variant) {
        'footer' => 'footer-brand-box',
        'sidebar' => 'sidebar-brand-logo',
        'login' => 'admin-login-brand-logo',
        default => 'navbar-brand-logo',
    };
@endphp

@if($logoUrl)
    <img
        src="{{ $logoUrl }}"
        alt="{{ $siteName }}"
        class="{{ $boxClass }} site-logo-img site-logo-img--{{ $variant }}"
    >
@else
    <div class="{{ $boxClass }}">B</div>
@endif
