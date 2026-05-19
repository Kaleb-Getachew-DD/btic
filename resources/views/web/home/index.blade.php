@extends('layouts.app')
@section('title', 'Home')

@section('content')

{{-- ===== HERO ===== --}}
<section class="hero">
    <div class="hero-bg-pattern"></div>
    <div class="hero-grid-lines"></div>
    <div class="hero-content">
        <div class="hero-text">
            <div class="hero-badge">
                <span class="hero-badge-dot"></span>
                Applications Open — Cohort 6
            </div>

            <h1 class="hero-title">
                Where Innovation<br>
                Meets <span class="highlight">Opportunity</span>
            </h1>

            <p class="hero-subtitle">
                Dire Dawa University's Business and Technology Incubation Center
                nurtures Ethiopia's boldest startup founders — providing mentorship,
                funding, workspace, and networks to build the future.
            </p>

            <div class="hero-actions">
                <a href="{{ route('apply.create') }}" class="btn btn-gold btn-lg">
                    <i class="fas fa-paper-plane"></i> Apply for Incubation
                </a>
                <a href="{{ route('startups.index') }}" class="btn btn-outline-white btn-lg">
                    <i class="fas fa-arrow-right"></i> Explore Startups
                </a>
            </div>

            <div class="hero-stats">
                <div class="hero-stat-item">
                    <div class="hero-stat-number" data-count="{{ preg_replace('/[^0-9]/', '', $stats['startups']) }}" data-suffix="+">{{ $stats['startups'] }}</div>
                    <div class="hero-stat-label">Startups</div>
                </div>
                <div class="hero-stat-item">
                    <div class="hero-stat-number" data-count="{{ $stats['cohorts'] }}">{{ $stats['cohorts'] }}</div>
                    <div class="hero-stat-label">Cohorts</div>
                </div>
                <div class="hero-stat-item">
                    <div class="hero-stat-number" data-count="{{ preg_replace('/[^0-9]/', '', $stats['jobs']) }}" data-suffix="+">{{ $stats['jobs'] }}</div>
                    <div class="hero-stat-label">Jobs Created</div>
                </div>
                <div class="hero-stat-item">
                    <div class="hero-stat-number">{{ $stats['funding'] }}</div>
                    <div class="hero-stat-label">Funding Raised</div>
                </div>
            </div>
        </div>

        <div class="hero-visual">
            <div class="hero-3d-card animate-float">
                <div class="hero-card-header">
                    <div class="hero-card-icon"><i class="fas fa-rocket"></i></div>
                    <div>
                        <div class="hero-card-title">Active Incubatees</div>
                        <div class="hero-card-sub">Cohort 6 — 2024/25</div>
                    </div>
                </div>
                @foreach($featuredStartups->take(4) as $startup)
                <div class="startup-list-item">
                    <div class="startup-avatar">{{ strtoupper(substr($startup->name, 0, 2)) }}</div>
                    <div>
                        <div class="startup-info-name">{{ $startup->name }}</div>
                        <div class="startup-info-sector">{{ $startup->sector }}</div>
                    </div>
                    <span class="startup-badge-pill">{{ ucfirst($startup->stage) }}</span>
                </div>
                @endforeach
                <div style="margin-top:16px;padding-top:16px;border-top:1px solid rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:space-between;">
                    <span style="font-size:0.75rem;color:rgba(255,255,255,0.5);">20 spots per cohort</span>
                    <a href="{{ route('apply.create') }}" style="font-size:0.75rem;color:#E8C04A;font-weight:600;">Apply →</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== STATS BAR ===== --}}
<section class="stats-bar">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number" data-count="{{ preg_replace('/[^0-9]/', '', $stats['startups']) }}" data-suffix="+">{{ $stats['startups'] }}</div>
                <div class="stat-label">Startups Incubated</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-count="{{ $stats['cohorts'] }}">{{ $stats['cohorts'] }}</div>
                <div class="stat-label">Cohorts Completed</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-count="{{ preg_replace('/[^0-9]/', '', $stats['jobs']) }}" data-suffix="+">{{ $stats['jobs'] }}</div>
                <div class="stat-label">Jobs Created</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $stats['funding'] }}</div>
                <div class="stat-label">Funding Raised</div>
            </div>
        </div>
    </div>
</section>

{{-- ===== ABOUT SNIPPET ===== --}}
<section class="section section-light">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:64px;align-items:center;">
            <div>
                <div class="section-tag"><i class="fas fa-info-circle"></i> About DDU BTIC</div>
                <h2 class="text-headline" style="margin-bottom:20px;">
                    Ethiopia's Premier University-Led Incubation Ecosystem
                </h2>
                <div class="divider-gold"></div>
                <p class="text-lead" style="margin-top:20px;">
                    Established within Dire Dawa University, the BTIC is dedicated to transforming
                    innovative ideas into scalable businesses that create jobs, drive economic growth,
                    and solve real challenges facing Ethiopia and East Africa.
                </p>
                <p style="margin-top:16px;color:var(--text-body);line-height:1.8;">
                    Through our structured incubation programs, world-class mentors, and strong
                    investor networks, we give founders everything they need to succeed — from idea
                    validation to Series A and beyond.
                </p>
                <div style="margin-top:32px;display:flex;gap:16px;flex-wrap:wrap;">
                    <a href="{{ route('about') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-right"></i> Learn More
                    </a>
                    <a href="{{ route('apply.create') }}" class="btn btn-outline">
                        <i class="fas fa-paper-plane"></i> Apply Today
                    </a>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                @php
                    $pillars = [
                        ['icon'=>'fa-lightbulb','title'=>'Idea Validation','desc'=>'Structured frameworks to test and refine your concept.'],
                        ['icon'=>'fa-code','title'=>'Product Development','desc'=>'Tech labs and expert guidance to build your MVP.'],
                        ['icon'=>'fa-coins','title'=>'Funding Access','desc'=>'Seed grants and investor introductions.'],
                        ['icon'=>'fa-users','title'=>'Mentorship','desc'=>'200+ mentors from business, tech, and academia.'],
                    ];
                @endphp
                @foreach($pillars as $pillar)
                <div style="background:white;border-radius:var(--radius-lg);padding:24px;border:1px solid var(--light-gray);transition:var(--transition);" class="program-card">
                    <div style="width:48px;height:48px;background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;margin-bottom:14px;">
                        <i class="fas {{ $pillar['icon'] }}" style="color:white;font-size:1.2rem;"></i>
                    </div>
                    <h4 style="font-size:0.95rem;font-weight:700;margin-bottom:8px;color:var(--text-dark);">{{ $pillar['title'] }}</h4>
                    <p style="font-size:0.82rem;color:var(--text-body);line-height:1.6;">{{ $pillar['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ===== PROGRAMS ===== --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag"><i class="fas fa-graduation-cap"></i> Our Programs</div>
            <h2 class="text-headline">Structured Support at Every Stage</h2>
            <p class="text-lead">From first idea to scale — we have a program designed for exactly where you are.</p>
        </div>
        <div class="programs-grid">
            @foreach($programs as $program)
            <div class="program-card">
                <div class="program-icon">
                    <i class="fas {{ $program->icon ?? 'fa-rocket' }}"></i>
                </div>
                <h3 class="program-title">{{ $program->title }}</h3>
                <p class="program-desc">{{ $program->short_description }}</p>
                @if($program->duration)
                    <span class="program-duration">
                        <i class="fas fa-clock"></i> {{ $program->duration }}
                    </span>
                @endif
                @if($program->benefits && count($program->benefits) > 0)
                    <div class="program-benefits">
                        @foreach(array_slice($program->benefits, 0, 3) as $benefit)
                            <div class="program-benefit">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ $benefit }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            @endforeach
        </div>
        <div style="text-align:center;margin-top:40px;">
            <a href="{{ route('programs.index') }}" class="btn btn-outline">
                View All Programs <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

{{-- ===== FEATURED STARTUPS ===== --}}
<section class="section section-light">
    <div class="container">
        <div class="section-header" style="display:flex;align-items:flex-end;justify-content:space-between;max-width:none;margin-bottom:40px;">
            <div>
                <div class="section-tag"><i class="fas fa-rocket"></i> Portfolio</div>
                <h2 class="text-headline">Featured Startups</h2>
                <p class="text-lead">Innovative companies built inside DDU BTIC.</p>
            </div>
            <a href="{{ route('startups.index') }}" class="btn btn-outline" style="flex-shrink:0;">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="startups-grid">
            @foreach($featuredStartups as $startup)
            <a href="{{ route('startups.show', $startup->slug) }}" class="startup-card">
                <div class="startup-card-cover">
                    @if($startup->cover_image)
                        <img src="{{ asset('storage/' . $startup->cover_image) }}" alt="{{ $startup->name }}">
                    @else
                        <div style="width:100%;height:100%;background:linear-gradient(135deg,var(--navy),var(--crimson));display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-rocket" style="font-size:3rem;color:rgba(255,255,255,0.2);"></i>
                        </div>
                    @endif
                    <span class="startup-sector-tag">{{ $startup->sector }}</span>
                    @if($startup->is_featured)
                        <span class="startup-featured-badge"><i class="fas fa-star"></i> Featured</span>
                    @endif
                    <div class="startup-card-logo">
                        @if($startup->logo)
                            <img src="{{ asset('storage/' . $startup->logo) }}" alt="{{ $startup->name }}" style="width:100%;height:100%;object-fit:contain;">
                        @else
                            {{ strtoupper(substr($startup->name, 0, 2)) }}
                        @endif
                    </div>
                </div>
                <div class="startup-card-body">
                    <h3 class="startup-card-name">{{ $startup->name }}</h3>
                    @if($startup->tagline)
                        <p class="startup-card-tagline">{{ $startup->tagline }}</p>
                    @endif
                    <p class="startup-card-desc">{{ Str::limit($startup->description, 100) }}</p>

                    @if($startup->metrics && count($startup->metrics) > 0)
                    <div class="startup-metrics">
                        @foreach(array_slice($startup->metrics, 0, 3) as $key => $value)
                        <div class="startup-metric">
                            <div class="startup-metric-value">{{ $value }}</div>
                            <div class="startup-metric-label">{{ ucfirst($key) }}</div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <div class="startup-cohort-tag">
                        <i class="fas fa-layer-group"></i>
                        {{ $startup->cohort_batch ?? 'BTIC Graduate' }}
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== SERVICES ===== --}}
<section class="section">
    <div class="container">
        <div class="section-header centered">
            <div class="section-tag"><i class="fas fa-concierge-bell"></i> Our Services</div>
            <h2 class="text-headline">Everything Your Startup Needs</h2>
            <p class="text-lead">Comprehensive support ecosystem designed to eliminate barriers to entrepreneurship.</p>
        </div>
        <div class="services-grid">
            @foreach($services as $service)
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas {{ $service->icon ?? 'fa-star' }}"></i>
                </div>
                <h3 class="service-title">{{ $service->title }}</h3>
                <p class="service-desc">{{ $service->description }}</p>
                @if($service->features && count($service->features) > 0)
                <div class="service-features">
                    @foreach(array_slice($service->features, 0, 3) as $feature)
                        <div class="service-feature">
                            <i class="fas fa-check"></i> {{ $feature }}
                        </div>
                    @endforeach
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== OPEN COHORT BANNER ===== --}}
@if($openCohort)
<section class="section-sm">
    <div class="container">
        <div class="cohort-open-banner">
            <div class="cohort-open-banner-text">
                <div class="label"><i class="fas fa-circle" style="font-size:0.5rem;margin-right:4px;"></i> Now Accepting Applications</div>
                <div class="title">{{ $openCohort->name }} — Applications Close {{ $openCohort->application_end->format('M d, Y') }}</div>
                <div class="sub">
                    {{ $openCohort->max_startups }} spots available
                    @if($openCohort->focus_areas)
                        · Focus: {{ implode(', ', array_slice($openCohort->focus_areas, 0, 3)) }}
                    @endif
                </div>
            </div>
            <a href="{{ route('apply.create') }}" class="btn btn-gold btn-lg" style="flex-shrink:0;">
                <i class="fas fa-paper-plane"></i> Apply Now
            </a>
        </div>
    </div>
</section>
@endif

{{-- ===== NEWS ===== --}}
<section class="section section-light">
    <div class="container">
        <div class="section-header" style="display:flex;align-items:flex-end;justify-content:space-between;max-width:none;margin-bottom:40px;">
            <div>
                <div class="section-tag"><i class="fas fa-newspaper"></i> Latest News</div>
                <h2 class="text-headline">Stories from the Ecosystem</h2>
            </div>
            <a href="{{ route('news.index') }}" class="btn btn-outline" style="flex-shrink:0;">
                All News <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="news-grid">
            @foreach($latestNews as $article)
            <a href="{{ route('news.show', $article->slug) }}" class="news-card">
                <div class="news-card-img">
                    @if($article->cover_image)
                        <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}">
                    @else
                        <div style="width:100%;height:100%;background:linear-gradient(135deg,var(--light-gray),var(--off-white));display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-newspaper" style="font-size:2.5rem;color:var(--mid-gray);opacity:0.5;"></i>
                        </div>
                    @endif
                    @if($article->category)
                        <span class="news-category-tag">{{ $article->category }}</span>
                    @endif
                </div>
                <div class="news-card-body">
                    <div class="news-meta">
                        <span class="news-date"><i class="fas fa-calendar" style="margin-right:4px;"></i>{{ $article->published_at ? $article->published_at->format('M d, Y') : '' }}</span>
                        <span class="news-read-time">· {{ $article->reading_time }}</span>
                    </div>
                    <h3 class="news-title">{{ $article->title }}</h3>
                    @if($article->excerpt)
                        <p class="news-excerpt">{{ $article->excerpt }}</p>
                    @endif
                    <div class="news-card-footer">
                        <div class="news-author">
                            <div class="news-author-avatar">{{ strtoupper(substr($article->author->name ?? 'A', 0, 1)) }}</div>
                            <span class="news-author-name">{{ $article->author->name ?? 'BTIC Team' }}</span>
                        </div>
                        <span style="font-size:0.8rem;color:var(--crimson);font-weight:600;">Read More →</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== TEAM SNIPPET ===== --}}
@if($teamMembers->count() > 0)
<section class="section">
    <div class="container">
        <div class="section-header centered">
            <div class="section-tag"><i class="fas fa-users"></i> Our Team</div>
            <h2 class="text-headline">The People Behind BTIC</h2>
            <p class="text-lead">Experienced professionals dedicated to building Ethiopia's next generation of entrepreneurs.</p>
        </div>
        <div class="team-grid">
            @foreach($teamMembers->take(4) as $member)
            <div class="team-card">
                <div class="team-photo-wrapper">
                    @if($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="team-photo">
                    @else
                        <div class="team-photo-placeholder">{{ strtoupper(substr($member->name, 0, 1)) }}</div>
                    @endif
                </div>
                <h4 class="team-name">{{ $member->name }}</h4>
                <p class="team-title">{{ $member->title }}</p>
                @if($member->bio)
                    <p class="team-bio">{{ Str::limit($member->bio, 80) }}</p>
                @endif
                <div class="team-socials">
                    @if($member->linkedin)
                        <a href="{{ $member->linkedin }}" class="team-social-link" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    @endif
                    @if($member->twitter)
                        <a href="{{ $member->twitter }}" class="team-social-link" target="_blank"><i class="fab fa-twitter"></i></a>
                    @endif
                    @if($member->email)
                        <a href="mailto:{{ $member->email }}" class="team-social-link"><i class="fas fa-envelope"></i></a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===== CTA ===== --}}
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <div class="section-tag" style="margin:0 auto 20px;display:inline-flex;">
                <i class="fas fa-paper-plane"></i> Take the First Step
            </div>
            <h2 class="cta-title">Ready to Build Your Startup with DDU BTIC?</h2>
            <p class="cta-subtitle">
                Join 60+ startups that have transformed their ideas into real businesses through the DDU BTIC program.
                Applications for Cohort 6 are now open.
            </p>
            <div class="cta-actions">
                <a href="{{ route('apply.create') }}" class="btn btn-gold btn-lg">
                    <i class="fas fa-paper-plane"></i> Apply for Incubation
                </a>
                <a href="{{ route('contact.index') }}" class="btn btn-outline-white btn-lg">
                    <i class="fas fa-envelope"></i> Ask Us Anything
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
