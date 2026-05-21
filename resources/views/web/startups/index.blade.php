@extends('layouts.app')
@section('title', 'Startup Portfolio')
@section('meta_description', 'Explore innovative startups incubated at DDU BTIC — Dire Dawa University Business and Technology Incubation Center.')

@section('content')

<section class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <div class="section-tag section-tag--on-dark">
                <i class="fas fa-rocket"></i> Our Portfolio
            </div>
            <h1 class="page-hero-title">Startups Built at DDU BTIC</h1>
            <p class="page-hero-sub">Discover the innovative companies that have grown out of our incubation programs — each solving real problems across Ethiopia.</p>
            <div class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span>/</span>
                <span class="current">Startups</span>
            </div>
        </div>
    </div>
</section>

<section class="section section-light">
    <div class="container">

        {{-- Filter Bar --}}
        <form method="GET" class="filter-bar">
            <div class="filter-search">
                <i class="fas fa-search filter-search-icon"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search startups...">
            </div>
            <select name="sector" class="filter-select" data-auto-submit>
                <option value="">All Sectors</option>
                @foreach($sectors as $sector)
                    <option value="{{ $sector }}" {{ request('sector') === $sector ? 'selected' : '' }}>{{ $sector }}</option>
                @endforeach
            </select>
            <select name="stage" class="filter-select" data-auto-submit>
                <option value="">All Stages</option>
                @foreach(['idea'=>'Idea','prototype'=>'Prototype','mvp'=>'MVP','early_traction'=>'Early Traction','growth'=>'Growth'] as $val => $label)
                    <option value="{{ $val }}" {{ request('stage') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Search</button>
            @if(request()->hasAny(['search','sector','stage']))
                <a href="{{ route('startups.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-times"></i> Clear</a>
            @endif
        </form>

        @if($startups->count() > 0)
            <div class="startups-grid">
                @foreach($startups as $startup)
                <a href="{{ route('startups.show', $startup->slug) }}" class="startup-card">
                    <div class="startup-card-cover">
                        @if($startup->cover_image)
                            <img src="{{ asset('storage/'.$startup->cover_image) }}" alt="{{ $startup->name }}">
                        @else
                            <div style="width:100%;height:100%;background:linear-gradient(135deg,var(--navy),var(--crimson));display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-rocket" style="font-size:3rem;color:rgba(255,255,255,0.15);"></i>
                            </div>
                        @endif
                        <span class="startup-sector-tag">{{ $startup->sector }}</span>
                        @if($startup->is_featured)
                            <span class="startup-featured-badge"><i class="fas fa-star"></i> Featured</span>
                        @endif
                        <div class="startup-card-logo">
                            @if($startup->logo)
                                <img src="{{ asset('storage/'.$startup->logo) }}" alt="{{ $startup->name }}" style="width:100%;height:100%;object-fit:contain;padding:6px;">
                            @else
                                {{ strtoupper(substr($startup->name,0,2)) }}
                            @endif
                        </div>
                    </div>
                    <div class="startup-card-body">
                        <h3 class="startup-card-name">{{ $startup->name }}</h3>
                        @if($startup->tagline)<p class="startup-card-tagline">{{ $startup->tagline }}</p>@endif
                        <p class="startup-card-desc">{{ Str::limit($startup->description, 110) }}</p>
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
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:4px;">
                            <span class="startup-cohort-tag"><i class="fas fa-layer-group"></i> {{ $startup->cohort_batch ?? 'BTIC Graduate' }}</span>
                            <span style="font-size:0.78rem;color:var(--crimson);font-weight:600;">View Details →</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            @if($startups->hasPages())
                <div class="pagination-wrapper">{{ $startups->links() }}</div>
            @endif
        @else
            <div style="text-align:center;padding:80px 24px;">
                <i class="fas fa-rocket" style="font-size:3rem;color:var(--mid-gray);opacity:0.3;margin-bottom:20px;display:block;"></i>
                <h3 style="font-size:1.2rem;font-weight:700;color:var(--text-dark);margin-bottom:8px;">No startups found</h3>
                <p style="color:var(--text-body);">Try adjusting your filters or <a href="{{ route('startups.index') }}" style="color:var(--crimson);">clear all filters</a>.</p>
            </div>
        @endif

        {{-- CTA --}}
        <div style="margin-top:64px;background:linear-gradient(135deg,var(--navy-dark),var(--navy));border-radius:var(--radius-xl);padding:48px;text-align:center;color:white;">
            <h2 style="font-family:var(--font-display);font-size:1.8rem;font-weight:800;color:white;margin-bottom:12px;">Want to Join This Portfolio?</h2>
            <p style="color:rgba(255,255,255,0.7);font-size:1rem;margin-bottom:28px;">Apply for our next cohort and get the mentorship, funding, and network to build something remarkable.</p>
            <a href="{{ route('apply.create') }}" class="btn btn-gold btn-lg"><i class="fas fa-paper-plane"></i> Apply for Incubation</a>
        </div>
    </div>
</section>

@endsection
