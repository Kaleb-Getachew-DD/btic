{{-- FILE: resources/views/web/programs/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Programs & Services')
@section('meta_description', 'DDU BTIC programs: Pre-Incubation, Core Incubation, Acceleration and Graduate Support — plus comprehensive services for startups.')

@section('content')
<section class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <div class="section-tag section-tag--on-dark">
                <i class="fas fa-graduation-cap"></i> Programs & Services
            </div>
            <h1 class="page-hero-title">Our Programs & Services</h1>
            <p class="page-hero-sub">From idea to scale — structured support at every stage of your entrepreneurial journey.</p>
            <div class="breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span><span class="current">Programs & Services</span></div>
        </div>
    </div>
</section>

{{-- Programs --}}
<section class="section">
    <div class="container">
        <div class="section-header centered">
            <div class="section-tag"><i class="fas fa-rocket"></i> Incubation Programs</div>
            <h2 class="text-headline">Structured Pathways to Success</h2>
            <p class="text-lead">Our programs are designed to meet you where you are and take you where you want to go.</p>
        </div>

        <div class="programs-list" style="display:flex;flex-direction:column;gap:32px;">
            @foreach($programs as $i => $program)
            <div class="program-card program-row" style="display:grid;grid-template-columns:{{ $i % 2 === 0 ? '1fr 2fr' : '2fr 1fr' }};gap:40px;align-items:center;background:white;border:1px solid var(--light-gray);border-radius:var(--radius-xl);padding:40px;box-shadow:var(--shadow-sm);transition:var(--transition);">
                @if($i % 2 === 0)
                <div class="program-row-icon" style="text-align:center;">
                    <div style="width:120px;height:120px;background:linear-gradient(135deg,var(--crimson),var(--navy));border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;box-shadow:0 20px 40px rgba(26,74,158,0.25);">
                        <i class="fas {{ $program->icon ?? 'fa-rocket' }}" style="font-size:3rem;color:white;"></i>
                    </div>
                    @if($program->duration)
                    <span class="program-duration"><i class="fas fa-clock"></i> {{ $program->duration }}</span>
                    @endif
                </div>
                @endif
                <div>
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
                        <span style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;background:var(--crimson);color:white;border-radius:50%;font-weight:800;font-size:1rem;">{{ $i + 1 }}</span>
                        <h3 style="font-size:1.4rem;font-weight:800;color:var(--text-dark);">{{ $program->title }}</h3>
                    </div>
                    <p style="font-size:1rem;color:var(--text-body);line-height:1.7;margin-bottom:16px;">{{ $program->short_description }}</p>
                    @if($program->eligibility)
                    <div style="background:var(--off-white);border-radius:var(--radius-sm);padding:10px 14px;margin-bottom:16px;font-size:0.85rem;color:var(--dark-gray);">
                        <strong style="color:var(--crimson);">Eligibility:</strong> {{ $program->eligibility }}
                    </div>
                    @endif
                    @if($program->benefits && count($program->benefits) > 0)
                    <div class="program-row-benefits" style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                        @foreach($program->benefits as $benefit)
                        <div style="display:flex;align-items:center;gap:8px;font-size:0.85rem;color:var(--text-body);">
                            <i class="fas fa-check-circle" style="color:var(--gold);flex-shrink:0;"></i>
                            {{ $benefit }}
                        </div>
                        @endforeach
                    </div>
                    @endif
                    <a href="{{ route('apply.create') }}" class="btn btn-primary" style="margin-top:20px;">
                        <i class="fas fa-paper-plane"></i> Apply to this Program
                    </a>
                </div>
                @if($i % 2 !== 0)
                <div class="program-row-icon" style="text-align:center;">
                    <div style="width:120px;height:120px;background:linear-gradient(135deg,var(--navy),var(--crimson));border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;box-shadow:0 20px 40px rgba(26,74,158,0.25);">
                        <i class="fas {{ $program->icon ?? 'fa-rocket' }}" style="font-size:3rem;color:white;"></i>
                    </div>
                    @if($program->duration)
                    <span class="program-duration"><i class="fas fa-clock"></i> {{ $program->duration }}</span>
                    @endif
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Services --}}
<section class="section section-light">
    <div class="container">
        <div class="section-header centered">
            <div class="section-tag"><i class="fas fa-concierge-bell"></i> Support Services</div>
            <h2 class="text-headline">Comprehensive Startup Support</h2>
            <p class="text-lead">Every resource and service you need to build, launch, and scale your startup.</p>
        </div>
        <div class="services-grid">
            @foreach($services as $service)
            <div class="service-card">
                <div class="service-icon"><i class="fas {{ $service->icon ?? 'fa-star' }}"></i></div>
                <h3 class="service-title">{{ $service->title }}</h3>
                <p class="service-desc">{{ $service->description }}</p>
                @if($service->features && count($service->features) > 0)
                <div class="service-features">
                    @foreach($service->features as $f)
                        <div class="service-feature"><i class="fas fa-check"></i> {{ $f }}</div>
                    @endforeach
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">Ready to Start Your Journey?</h2>
            <p class="cta-subtitle">Apply now and gain access to all our programs, services, and the DDU BTIC network.</p>
            <div class="cta-actions">
                <a href="{{ route('apply.create') }}" class="btn btn-gold btn-lg"><i class="fas fa-paper-plane"></i> Apply Today</a>
                <a href="{{ route('contact.index') }}" class="btn btn-outline-white btn-lg"><i class="fas fa-envelope"></i> Ask a Question</a>
            </div>
        </div>
    </div>
</section>
@endsection
