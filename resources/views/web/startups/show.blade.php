@extends('layouts.app')
@section('title', $startup->name . ' — DDU BTIC Portfolio')
@section('meta_description', $startup->tagline ?? Str::limit($startup->description, 155))

@section('content')

{{-- Hero --}}
<div class="startup-hero">
    <div style="position:absolute;inset:0;background:linear-gradient(135deg,var(--navy-dark) 0%,var(--navy) 60%,rgba(26,74,158,0.3) 100%);"></div>
    <div style="position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,0.02) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,0.02) 1px,transparent 1px);background-size:50px 50px;"></div>
    @if($startup->cover_image)
    <div style="position:absolute;inset:0;"><img src="{{ asset('storage/'.$startup->cover_image) }}" alt="" style="width:100%;height:100%;object-fit:cover;opacity:0.08;"></div>
    @endif
    <div class="container" style="padding-top:100px;padding-bottom:80px;position:relative;z-index:2;">
        <div class="breadcrumb" style="margin-bottom:28px;">
            <a href="{{ route('home') }}" style="color:rgba(255,255,255,0.5);">Home</a>
            <span style="color:rgba(255,255,255,0.3);">/</span>
            <a href="{{ route('startups.index') }}" style="color:rgba(255,255,255,0.5);">Startups</a>
            <span style="color:rgba(255,255,255,0.3);">/</span>
            <span style="color:var(--gold);">{{ $startup->name }}</span>
        </div>
        <div class="startup-hero-content">
            <div class="startup-logo-large">
                @if($startup->logo)
                    <img src="{{ asset('storage/'.$startup->logo) }}" alt="{{ $startup->name }}" style="width:100%;height:100%;object-fit:contain;padding:8px;">
                @else
                    {{ strtoupper(substr($startup->name,0,2)) }}
                @endif
            </div>
            <div>
                @if($startup->is_featured)
                    <div style="display:inline-flex;align-items:center;gap:6px;background:rgba(255,222,0,0.2);border:1px solid rgba(255,222,0,0.4);color:var(--gold-light);border-radius:100px;padding:5px 14px;font-size:0.75rem;font-weight:600;margin-bottom:12px;">
                        <i class="fas fa-star"></i> Featured Startup
                    </div>
                @endif
                <h1 style="font-family:var(--font-display);font-size:clamp(1.8rem,4vw,3rem);font-weight:800;color:white;margin-bottom:8px;">{{ $startup->name }}</h1>
                @if($startup->tagline)
                    <p style="font-size:1.1rem;color:rgba(255,255,255,0.75);margin-bottom:20px;">{{ $startup->tagline }}</p>
                @endif
                <div class="startup-hero-meta">
                    <span class="startup-hero-badge"><i class="fas fa-tag"></i> {{ $startup->sector }}</span>
                    <span class="startup-hero-badge"><i class="fas fa-chart-line"></i> {{ ucfirst(str_replace('_',' ',$startup->stage)) }}</span>
                    @if($startup->location)<span class="startup-hero-badge"><i class="fas fa-map-marker-alt"></i> {{ $startup->location }}</span>@endif
                    @if($startup->founded_year)<span class="startup-hero-badge"><i class="fas fa-calendar"></i> Founded {{ $startup->founded_year }}</span>@endif
                    @if($startup->cohort_batch)<span class="startup-hero-badge"><i class="fas fa-layer-group"></i> {{ $startup->cohort_batch }}</span>@endif
                </div>
            </div>
        </div>

        {{-- Key Metrics Bar --}}
        @if($startup->metrics && count($startup->metrics) > 0)
        <div class="startup-metrics-bar" style="margin-top:40px;display:flex;gap:0;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:var(--radius-lg);overflow:hidden;backdrop-filter:blur(10px);">
            @foreach($startup->metrics as $key => $value)
            <div style="flex:1;padding:20px 24px;border-right:1px solid rgba(255,255,255,0.1);text-align:center;">
                <div style="font-family:var(--font-display);font-size:1.75rem;font-weight:800;color:var(--gold);line-height:1;">{{ $value }}</div>
                <div style="font-size:0.75rem;color:rgba(255,255,255,0.5);margin-top:4px;text-transform:uppercase;letter-spacing:0.05em;">{{ ucfirst($key) }}</div>
            </div>
            @if(!$loop->last)@endif
            @endforeach
        </div>
        @endif
    </div>
</div>

{{-- Main Content --}}
<section class="section">
    <div class="container">
        <div class="startup-main-grid" style="display:grid;grid-template-columns:1fr 340px;gap:48px;align-items:start;">

            {{-- Left --}}
            <div>
                {{-- About --}}
                <div style="margin-bottom:40px;">
                    <div class="section-tag"><i class="fas fa-info-circle"></i> About</div>
                    <h2 style="font-size:1.5rem;font-weight:700;margin-bottom:16px;color:var(--text-dark);">About {{ $startup->name }}</h2>
                    <div class="divider-gold"></div>
                    <p style="font-size:1rem;line-height:1.8;color:var(--text-body);margin-top:16px;">{{ $startup->description }}</p>
                    @if($startup->full_story)
                        <div style="margin-top:16px;font-size:0.95rem;line-height:1.8;color:var(--text-body);">{!! nl2br(e($startup->full_story)) !!}</div>
                    @endif
                </div>

                {{-- Achievements --}}
                @if($startup->achievements && count($startup->achievements) > 0)
                <div style="margin-bottom:40px;">
                    <div class="section-tag"><i class="fas fa-trophy"></i> Milestones</div>
                    <h2 style="font-size:1.3rem;font-weight:700;margin-bottom:20px;color:var(--text-dark);">Key Achievements</h2>
                    <div style="display:flex;flex-direction:column;gap:12px;">
                        @foreach($startup->achievements as $achievement)
                        <div style="display:flex;align-items:flex-start;gap:14px;padding:16px 20px;background:var(--off-white);border-radius:var(--radius-md);border-left:4px solid var(--gold);">
                            <div style="width:28px;height:28px;background:var(--gold-pale);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">
                                <i class="fas fa-star" style="color:var(--gold);font-size:0.65rem;"></i>
                            </div>
                            <span style="font-size:0.9rem;color:var(--text-dark);font-weight:500;line-height:1.5;">{{ $achievement }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Founder --}}
                <div style="margin-bottom:40px;">
                    <div class="section-tag"><i class="fas fa-user"></i> Founder</div>
                    <h2 style="font-size:1.3rem;font-weight:700;margin-bottom:20px;color:var(--text-dark);">Meet the Founder</h2>
                    <div class="startup-founder-card" style="display:flex;gap:24px;align-items:flex-start;background:white;border:1px solid var(--light-gray);border-radius:var(--radius-xl);padding:28px;box-shadow:var(--shadow-sm);">
                        <div style="flex-shrink:0;">
                            @if($startup->founder_photo)
                                <img src="{{ asset('storage/'.$startup->founder_photo) }}" alt="{{ $startup->founder_name }}"
                                    style="width:90px;height:90px;border-radius:50%;object-fit:cover;border:4px solid var(--white);box-shadow:var(--shadow-md);">
                            @else
                                <div style="width:90px;height:90px;border-radius:50%;background:linear-gradient(135deg,var(--crimson),var(--navy));display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:800;color:white;font-family:var(--font-display);">
                                    {{ strtoupper(substr($startup->founder_name,0,1)) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <h3 style="font-size:1.1rem;font-weight:700;color:var(--text-dark);margin-bottom:4px;">{{ $startup->founder_name }}</h3>
                            @if($startup->founder_title)<p style="font-size:0.85rem;color:var(--crimson);font-weight:600;margin-bottom:10px;">{{ $startup->founder_title }}</p>@endif
                            @if($startup->founder_bio)<p style="font-size:0.875rem;color:var(--text-body);line-height:1.7;">{{ $startup->founder_bio }}</p>@endif
                            @if($startup->team_size && $startup->team_size > 1)
                                <div style="margin-top:10px;font-size:0.8rem;color:var(--mid-gray);">
                                    <i class="fas fa-users" style="margin-right:4px;"></i> Team of {{ $startup->team_size }} people
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Related Startups --}}
                @if($related->count() > 0)
                <div>
                    <h2 style="font-size:1.3rem;font-weight:700;margin-bottom:20px;color:var(--text-dark);">More {{ $startup->sector }} Startups</h2>
                    <div class="startup-related-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:20px;">
                        @foreach($related as $rel)
                        <a href="{{ route('startups.show',$rel->slug) }}" class="startup-card startup-related-item" style="background:white;border:1px solid var(--light-gray);border-radius:var(--radius-lg);padding:20px;display:flex;align-items:center;gap:14px;transition:var(--transition);">
                            <div style="width:48px;height:48px;background:linear-gradient(135deg,var(--navy),var(--crimson));border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;font-size:1rem;font-weight:800;color:white;font-family:var(--font-display);flex-shrink:0;">
                                {{ strtoupper(substr($rel->name,0,2)) }}
                            </div>
                            <div>
                                <div style="font-size:0.9rem;font-weight:700;color:var(--text-dark);">{{ $rel->name }}</div>
                                <div style="font-size:0.75rem;color:var(--mid-gray);">{{ $rel->sector }}</div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- Right Sidebar --}}
            <div class="startup-sidebar" style="position:sticky;top:96px;">
                {{-- Contact Card --}}
                <div style="background:white;border:1px solid var(--light-gray);border-radius:var(--radius-xl);overflow:hidden;box-shadow:var(--shadow-md);margin-bottom:20px;">
                    <div style="background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));padding:20px 24px;color:white;">
                        <h3 style="font-size:1rem;font-weight:700;color:white;margin-bottom:4px;">Connect with {{ $startup->name }}</h3>
                        <p style="font-size:0.8rem;color:rgba(255,255,255,0.7);">Interested in partnering or investing?</p>
                    </div>
                    <div style="padding:20px 24px;">
                        @if($startup->website)
                        <a href="{{ $startup->website }}" target="_blank" style="display:flex;align-items:center;gap:10px;padding:10px 14px;border:1.5px solid var(--light-gray);border-radius:var(--radius-sm);font-size:0.85rem;font-weight:500;color:var(--text-dark);margin-bottom:10px;transition:var(--transition);">
                            <i class="fas fa-globe" style="color:var(--crimson);width:16px;"></i> Visit Website
                            <i class="fas fa-external-link-alt" style="margin-left:auto;font-size:0.7rem;color:var(--mid-gray);"></i>
                        </a>
                        @endif
                        @if($startup->email)
                        <a href="mailto:{{ $startup->email }}" style="display:flex;align-items:center;gap:10px;padding:10px 14px;border:1.5px solid var(--light-gray);border-radius:var(--radius-sm);font-size:0.85rem;font-weight:500;color:var(--text-dark);margin-bottom:10px;transition:var(--transition);">
                            <i class="fas fa-envelope" style="color:var(--crimson);width:16px;"></i> {{ $startup->email }}
                        </a>
                        @endif
                        @if($startup->phone)
                        <a href="tel:{{ $startup->phone }}" style="display:flex;align-items:center;gap:10px;padding:10px 14px;border:1.5px solid var(--light-gray);border-radius:var(--radius-sm);font-size:0.85rem;font-weight:500;color:var(--text-dark);margin-bottom:10px;transition:var(--transition);">
                            <i class="fas fa-phone" style="color:var(--crimson);width:16px;"></i> {{ $startup->phone }}
                        </a>
                        @endif
                        @if($startup->linkedin || $startup->twitter || $startup->facebook)
                        <div style="display:flex;gap:8px;margin-top:14px;padding-top:14px;border-top:1px solid var(--light-gray);">
                            @if($startup->linkedin)<a href="{{ $startup->linkedin }}" target="_blank" class="team-social-link"><i class="fab fa-linkedin-in"></i></a>@endif
                            @if($startup->twitter)<a href="{{ $startup->twitter }}" target="_blank" class="team-social-link"><i class="fab fa-twitter"></i></a>@endif
                            @if($startup->facebook)<a href="{{ $startup->facebook }}" target="_blank" class="team-social-link"><i class="fab fa-facebook-f"></i></a>@endif
                        </div>
                        @endif
                        <a href="{{ route('contact.index') }}" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:14px;">
                            <i class="fas fa-handshake"></i> Contact BTIC to Connect
                        </a>
                    </div>
                </div>

                {{-- Quick Stats --}}
                <div style="background:var(--navy-dark);border-radius:var(--radius-xl);padding:24px;color:white;">
                    <h4 style="font-size:0.85rem;font-weight:700;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:16px;">Startup Profile</h4>
                    <div style="display:flex;flex-direction:column;gap:12px;">
                        @php
                            $profile = [
                                ['icon'=>'fa-tag','label'=>'Sector','value'=>$startup->sector],
                                ['icon'=>'fa-chart-line','label'=>'Stage','value'=>ucfirst(str_replace('_',' ',$startup->stage))],
                                ['icon'=>'fa-map-marker-alt','label'=>'Location','value'=>$startup->location ?? 'Dire Dawa, Ethiopia'],
                                ['icon'=>'fa-calendar','label'=>'Founded','value'=>$startup->founded_year ?? 'N/A'],
                                ['icon'=>'fa-users','label'=>'Team Size','value'=>($startup->team_size ?? 'N/A').' people'],
                                ['icon'=>'fa-layer-group','label'=>'Cohort','value'=>$startup->cohort_batch ?? 'BTIC Graduate'],
                            ];
                        @endphp
                        @foreach($profile as $item)
                        <div style="display:flex;align-items:center;justify-content:space-between;padding-bottom:10px;border-bottom:1px solid rgba(255,255,255,0.06);">
                            <div style="display:flex;align-items:center;gap:8px;font-size:0.8rem;color:rgba(255,255,255,0.45);">
                                <i class="fas {{ $item['icon'] }}" style="width:14px;"></i> {{ $item['label'] }}
                            </div>
                            <div style="font-size:0.82rem;font-weight:600;color:rgba(255,255,255,0.85);">{{ $item['value'] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">Inspired by {{ $startup->name }}?</h2>
            <p class="cta-subtitle">Your startup could be next. Apply to DDU BTIC and get the support to build something extraordinary.</p>
            <div class="cta-actions">
                <a href="{{ route('apply.create') }}" class="btn btn-gold btn-lg"><i class="fas fa-paper-plane"></i> Apply Now</a>
                <a href="{{ route('startups.index') }}" class="btn btn-outline-white btn-lg"><i class="fas fa-arrow-left"></i> All Startups</a>
            </div>
        </div>
    </div>
</section>

@endsection
