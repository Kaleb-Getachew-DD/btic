{{-- FILE: resources/views/web/about/index.blade.php --}}
@extends('layouts.app')
@section('title', 'About DDU BTIC')

@section('content')
<section class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <div class="section-tag section-tag--on-dark">
                <i class="fas fa-info-circle"></i> About Us
            </div>
            <h1 class="page-hero-title">About DDU BTIC</h1>
            <p class="page-hero-sub">Learn about our mission, vision, values, and the dedicated team building Ethiopia's innovation ecosystem.</p>
            <div class="breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span><span class="current">About</span></div>
        </div>
    </div>
</section>

{{-- About Story --}}
<section class="section">
    <div class="container">
        <div class="about-story-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:64px;align-items:center;margin-bottom:64px;">
            <div>
                <div class="section-tag"><i class="fas fa-history"></i> Our Story</div>
                <h2 class="text-headline" style="margin-bottom:20px;">Building Tomorrow's Economy, Today</h2>
                <div class="divider-gold"></div>
                <p class="text-lead" style="margin-top:20px;">
                    Dire Dawa University's Business and Technology Incubation Center (BTIC) was established with a bold vision: to transform Ethiopia's second-largest city into a hub for innovation and entrepreneurship.
                </p>
                <p style="margin-top:16px;color:var(--text-body);line-height:1.8;">
                    Since our founding, we have incubated over 60 startups across sectors including AgriTech, HealthTech, EdTech, FinTech, and Clean Technology. Our graduates have created hundreds of jobs, raised millions in funding, and built products serving tens of thousands of Ethiopians.
                </p>
                <p style="margin-top:16px;color:var(--text-body);line-height:1.8;">
                    Backed by Dire Dawa University's academic resources, research infrastructure, and a world-class mentor network, BTIC provides founders with everything they need from first idea to international scale.
                </p>
            </div>
            <div class="about-story-stats" style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                @php
                    $cards = [
                        ['num'=>'60+','label'=>'Startups Incubated','icon'=>'fa-rocket','color'=>'var(--crimson)'],
                        ['num'=>'6','label'=>'Cohorts Completed','icon'=>'fa-layer-group','color'=>'var(--navy)'],
                        ['num'=>'300+','label'=>'Jobs Created','icon'=>'fa-users','color'=>'var(--gold)','dark'=>true],
                        ['num'=>'$1M+','label'=>'Funding Raised','icon'=>'fa-coins','color'=>'var(--crimson)'],
                    ];
                @endphp
                @foreach($cards as $card)
                <div style="background:white;border:1px solid var(--light-gray);border-radius:var(--radius-lg);padding:24px;text-align:center;box-shadow:var(--shadow-sm);transition:var(--transition);" class="value-card">
                    <div style="width:56px;height:56px;background:{{ $card['color'] }};border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;opacity:0.9;">
                        <i class="fas {{ $card['icon'] }}" style="color:white;font-size:1.25rem;"></i>
                    </div>
                    <div style="font-family:var(--font-display);font-size:2rem;font-weight:800;color:var(--text-dark);line-height:1;">{{ $card['num'] }}</div>
                    <div style="font-size:0.8rem;color:var(--mid-gray);margin-top:4px;">{{ $card['label'] }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Mission & Vision --}}
        <div class="mission-vision-grid">
            <div class="mission-card">
                <div style="width:50px;height:50px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
                    <i class="fas fa-bullseye" style="font-size:1.25rem;color:var(--gold);"></i>
                </div>
                <h3>Our Mission</h3>
                <p style="color:rgba(255,255,255,0.85);line-height:1.8;font-size:0.95rem;margin-top:12px;">
                    To identify, nurture, and accelerate innovative startups in Dire Dawa and surrounding regions by providing world-class incubation programs, mentorship, and access to funding and markets — creating sustainable jobs and driving economic transformation in Ethiopia.
                </p>
            </div>
            <div class="vision-card">
                <div style="width:50px;height:50px;background:rgba(255,255,255,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
                    <i class="fas fa-eye" style="font-size:1.25rem;color:var(--gold);"></i>
                </div>
                <h3>Our Vision</h3>
                <p style="color:rgba(255,255,255,0.85);line-height:1.8;font-size:0.95rem;margin-top:12px;">
                    To be recognized as East Africa's leading university-based incubation center — producing globally competitive startups that leverage technology to solve Africa's most pressing challenges, positioning Dire Dawa as a continental innovation hub by 2030.
                </p>
            </div>
        </div>

        {{-- Values --}}
        <div style="margin-top:64px;">
            <div class="section-header centered" style="margin-bottom:40px;">
                <div class="section-tag"><i class="fas fa-heart"></i> Our Values</div>
                <h2 class="text-headline">What We Stand For</h2>
            </div>
            <div class="values-grid">
                @php
                    $values = [
                        ['icon'=>'🚀','title'=>'Innovation First','desc'=>'We champion bold, disruptive ideas that challenge the status quo and reimagine what is possible.'],
                        ['icon'=>'🤝','title'=>'Inclusive Growth','desc'=>'We prioritize women, youth, and underrepresented founders to ensure innovation benefits all Ethiopians.'],
                        ['icon'=>'🎯','title'=>'Impact-Driven','desc'=>'Every startup we support must demonstrate clear social or economic impact for communities.'],
                        ['icon'=>'🌍','title'=>'Global Mindset','desc'=>'We build startups with the ambition and capacity to compete on the global stage.'],
                        ['icon'=>'💡','title'=>'Learning Culture','desc'=>'We embrace failure as a teacher and champion continuous learning at every stage.'],
                        ['icon'=>'⚡','title'=>'Execution Excellence','desc'=>'Ideas only matter if executed. We focus relentlessly on building, measuring, and iterating.'],
                    ];
                @endphp
                @foreach($values as $value)
                <div class="value-card">
                    <div class="value-icon">{{ $value['icon'] }}</div>
                    <div class="value-title">{{ $value['title'] }}</div>
                    <div class="value-desc">{{ $value['desc'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Team --}}
@if($teamMembers->count() > 0)
<section class="section section-light">
    <div class="container">
        <div class="section-header centered">
            <div class="section-tag"><i class="fas fa-users"></i> Our Team</div>
            <h2 class="text-headline">The People Behind BTIC</h2>
            <p class="text-lead">Our dedicated team of professionals who guide, mentor, and support every startup in our ecosystem.</p>
        </div>
        <div class="team-grid">
            @foreach($teamMembers as $member)
            <div class="team-card">
                <div class="team-photo-wrapper">
                    @if($member->photo)
                        <img src="{{ asset('storage/'.$member->photo) }}" alt="{{ $member->name }}" class="team-photo">
                    @else
                        <div class="team-photo-placeholder">{{ strtoupper(substr($member->name,0,1)) }}</div>
                    @endif
                </div>
                <h4 class="team-name">{{ $member->name }}</h4>
                <p class="team-title">{{ $member->title }}</p>
                @if($member->department)
                    <span style="display:inline-flex;padding:2px 10px;background:var(--gold-pale);color:var(--crimson);border-radius:100px;font-size:0.7rem;font-weight:600;margin-bottom:8px;">{{ $member->department }}</span>
                @endif
                @if($member->bio)<p class="team-bio">{{ Str::limit($member->bio,100) }}</p>@endif
                <div class="team-socials">
                    @if($member->linkedin)<a href="{{ $member->linkedin }}" class="team-social-link" target="_blank"><i class="fab fa-linkedin-in"></i></a>@endif
                    @if($member->email)<a href="mailto:{{ $member->email }}" class="team-social-link"><i class="fas fa-envelope"></i></a>@endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">Join the DDU BTIC Community</h2>
            <p class="cta-subtitle">Whether you're a founder, mentor, investor, or partner — there's a place for you in our ecosystem.</p>
            <div class="cta-actions">
                <a href="{{ route('apply.create') }}" class="btn btn-gold btn-lg"><i class="fas fa-paper-plane"></i> Apply as Founder</a>
                <a href="{{ route('contact.index') }}" class="btn btn-outline-white btn-lg"><i class="fas fa-handshake"></i> Partner with Us</a>
            </div>
        </div>
    </div>
</section>
@endsection
