@props(['variant' => 'navbar', 'animated' => false])

@php
    $logoUrl = \App\Models\Setting::assetUrl('university_logo');
    $name = \App\Models\Setting::get('university_name', 'DDU');
    $subtitle = \App\Models\Setting::get('university_subtitle', 'Dire Dawa University');
    $url = \App\Models\Setting::get('university_url', '');
    $tag = $url ? 'a' : 'div';
@endphp

<{{ $tag }}
    @if($url) href="{{ $url }}" target="_blank" rel="noopener noreferrer" @endif
    class="university-badge university-badge--{{ $variant }}"
    @if($variant === 'navbar') title="{{ $subtitle }}" aria-label="{{ $subtitle }}" @endif
>
    <div class="university-badge__inner">
        @if($logoUrl)
            <img src="{{ $logoUrl }}" alt="{{ $subtitle }}" class="university-badge__logo-img">
        @else
            <div class="university-badge__logo-text">{{ $name }}</div>
            @if($variant !== 'navbar')
                <div class="university-badge__logo-sub">
                    @foreach(explode(' ', $subtitle) as $word)
                        <span>{{ $word }}</span>
                    @endforeach
                </div>
            @endif
        @endif
    </div>
</{{ $tag }}>
