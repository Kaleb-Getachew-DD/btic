@extends('layouts.app')
@section('title', $article->meta_title ?? $article->title)
@section('meta_description', $article->meta_description ?? $article->excerpt)

@section('content')

{{-- Article Hero --}}
<div style="background:linear-gradient(135deg,var(--navy-dark),var(--navy));padding:100px 0 64px;position:relative;overflow:hidden;">
    @if($article->cover_image)
        <div style="position:absolute;inset:0;"><img src="{{ asset('storage/'.$article->cover_image) }}" alt="" style="width:100%;height:100%;object-fit:cover;opacity:0.1;"></div>
    @endif
    <div class="container" style="position:relative;z-index:2;max-width:860px;">
        <div class="breadcrumb" style="margin-bottom:20px;">
            <a href="{{ route('home') }}" style="color:rgba(255,255,255,0.5);">Home</a>
            <span style="color:rgba(255,255,255,0.3);">/</span>
            <a href="{{ route('news.index') }}" style="color:rgba(255,255,255,0.5);">News</a>
            <span style="color:rgba(255,255,255,0.3);">/</span>
            <span style="color:var(--gold);">Article</span>
        </div>
        @if($article->category)
            <span style="display:inline-flex;align-items:center;gap:6px;background:var(--crimson);color:white;border-radius:100px;padding:5px 14px;font-size:0.75rem;font-weight:600;margin-bottom:16px;">
                {{ $article->category }}
            </span>
        @endif
        <h1 style="font-family:var(--font-display);font-size:clamp(1.8rem,4vw,2.8rem);font-weight:800;color:white;line-height:1.2;margin-bottom:20px;">
            {{ $article->title }}
        </h1>
        <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;background:var(--crimson);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.85rem;font-weight:700;color:white;">
                    {{ strtoupper(substr($article->author->name ?? 'A',0,1)) }}
                </div>
                <div>
                    <div style="font-size:0.85rem;font-weight:600;color:white;">{{ $article->author->name ?? 'BTIC Team' }}</div>
                    <div style="font-size:0.72rem;color:rgba(255,255,255,0.5);">Author</div>
                </div>
            </div>
            <div style="font-size:0.8rem;color:rgba(255,255,255,0.5);display:flex;align-items:center;gap:6px;">
                <i class="fas fa-calendar"></i>
                {{ $article->published_at?->format('F j, Y') }}
            </div>
            <div style="font-size:0.8rem;color:rgba(255,255,255,0.5);display:flex;align-items:center;gap:6px;">
                <i class="fas fa-clock"></i>
                {{ $article->reading_time }}
            </div>
            <div style="font-size:0.8rem;color:rgba(255,255,255,0.5);display:flex;align-items:center;gap:6px;">
                <i class="fas fa-eye"></i>
                {{ number_format($article->views) }} views
            </div>
        </div>
    </div>
</div>

{{-- Cover Image --}}
@if($article->cover_image)
<div style="background:var(--off-white);padding:0;">
    <div style="max-width:860px;margin:0 auto;padding:0 24px;">
        <img src="{{ asset('storage/'.$article->cover_image) }}" alt="{{ $article->title }}"
            style="width:100%;max-height:450px;object-fit:cover;border-radius:0 0 var(--radius-xl) var(--radius-xl);box-shadow:var(--shadow-xl);">
    </div>
</div>
@endif

{{-- Content --}}
<section class="section">
    <div style="max-width:860px;margin:0 auto;padding:0 24px;">
        <div style="display:grid;grid-template-columns:1fr 280px;gap:48px;align-items:start;">
            {{-- Article Body --}}
            <div>
                @if($article->excerpt)
                <div style="font-size:1.1rem;font-weight:500;color:var(--text-dark);line-height:1.8;border-left:4px solid var(--crimson);padding-left:20px;margin-bottom:32px;font-style:italic;">
                    {{ $article->excerpt }}
                </div>
                @endif

                <div class="article-content" style="font-size:0.95rem;line-height:1.85;color:var(--text-body);">
                    {!! $article->content !!}
                </div>

                {{-- Tags --}}
                @if($article->tags && count($article->tags) > 0)
                <div style="margin-top:40px;padding-top:24px;border-top:1px solid var(--light-gray);">
                    <span style="font-size:0.8rem;font-weight:600;color:var(--mid-gray);margin-right:10px;">Tags:</span>
                    @foreach($article->tags as $tag)
                        <a href="{{ route('news.index',['search'=>$tag]) }}" style="display:inline-flex;align-items:center;padding:4px 12px;background:var(--gold-pale);color:var(--crimson);border-radius:100px;font-size:0.75rem;font-weight:600;margin:2px 4px 2px 0;border:1px solid var(--gold);transition:var(--transition);">
                            #{{ $tag }}
                        </a>
                    @endforeach
                </div>
                @endif

                {{-- Share --}}
                <div style="margin-top:32px;padding:20px 24px;background:var(--off-white);border-radius:var(--radius-lg);display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;">
                    <span style="font-size:0.85rem;font-weight:600;color:var(--text-dark);">Share this article:</span>
                    <div style="display:flex;gap:10px;">
                        <a href="https://twitter.com/share?text={{ urlencode($article->title) }}&url={{ urlencode(request()->url()) }}" target="_blank" class="team-social-link" style="background:var(--blue);color:var(--white);"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($article->title) }}" target="_blank" class="team-social-link" style="background:var(--green);color:var(--white);"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="team-social-link" style="background:var(--brown);color:var(--white);"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div style="position:sticky;top:96px;">
                {{-- Author Card --}}
                <div style="background:white;border:1px solid var(--light-gray);border-radius:var(--radius-xl);padding:24px;box-shadow:var(--shadow-sm);margin-bottom:20px;text-align:center;">
                    <div style="width:70px;height:70px;background:linear-gradient(135deg,var(--crimson),var(--navy));border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.5rem;font-weight:800;color:white;margin:0 auto 14px;">
                        {{ strtoupper(substr($article->author->name ?? 'A',0,1)) }}
                    </div>
                    <h4 style="font-size:0.95rem;font-weight:700;color:var(--text-dark);margin-bottom:4px;">{{ $article->author->name ?? 'BTIC Team' }}</h4>
                    <p style="font-size:0.75rem;color:var(--mid-gray);">DDU BTIC Editorial</p>
                </div>

                {{-- CTA Card --}}
                <div style="background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));border-radius:var(--radius-xl);padding:24px;color:white;text-align:center;margin-bottom:20px;">
                    <i class="fas fa-paper-plane" style="font-size:2rem;margin-bottom:12px;opacity:0.8;"></i>
                    <h4 style="color:white;margin-bottom:8px;font-size:0.95rem;">Apply to BTIC</h4>
                    <p style="font-size:0.8rem;color:rgba(255,255,255,0.75);margin-bottom:16px;line-height:1.6;">Got a startup idea? Join Ethiopia's premier incubation program.</p>
                    <a href="{{ route('apply.create') }}" class="btn btn-gold btn-sm" style="width:100%;justify-content:center;">Apply Now →</a>
                </div>

                {{-- Related --}}
                @if($related->count() > 0)
                <div style="background:white;border:1px solid var(--light-gray);border-radius:var(--radius-xl);overflow:hidden;box-shadow:var(--shadow-sm);">
                    <div style="padding:14px 20px;background:var(--off-white);border-bottom:1px solid var(--light-gray);font-size:0.82rem;font-weight:700;color:var(--text-dark);">Related Articles</div>
                    @foreach($related as $rel)
                    <a href="{{ route('news.show',$rel->slug) }}" style="display:flex;align-items:flex-start;gap:12px;padding:14px 20px;border-bottom:1px solid var(--light-gray);transition:var(--transition);">
                        <div style="width:50px;height:50px;border-radius:var(--radius-sm);background:linear-gradient(135deg,var(--light-gray),var(--off-white));flex-shrink:0;overflow:hidden;">
                            @if($rel->cover_image)<img src="{{ asset('storage/'.$rel->cover_image) }}" alt="" style="width:100%;height:100%;object-fit:cover;">@endif
                        </div>
                        <div>
                            <div style="font-size:0.8rem;font-weight:600;color:var(--text-dark);line-height:1.4;">{{ Str::limit($rel->title,55) }}</div>
                            <div style="font-size:0.7rem;color:var(--mid-gray);margin-top:3px;">{{ $rel->published_at?->format('M d, Y') }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
.article-content h1,.article-content h2,.article-content h3{color:var(--text-dark);font-family:var(--font-display);margin:28px 0 14px;}
.article-content h2{font-size:1.4rem;}
.article-content h3{font-size:1.15rem;}
.article-content p{margin-bottom:16px;}
.article-content ul,.article-content ol{margin:16px 0 16px 24px;}
.article-content li{margin-bottom:6px;line-height:1.7;}
.article-content blockquote{border-left:4px solid var(--crimson);padding:16px 20px;background:var(--off-white);margin:24px 0;border-radius:0 var(--radius-sm) var(--radius-sm) 0;font-style:italic;color:var(--dark-gray);}
.article-content img{border-radius:var(--radius-md);margin:20px 0;box-shadow:var(--shadow-md);}
.article-content a{color:var(--crimson);text-decoration:underline;}
.article-content strong{color:var(--text-dark);}
</style>
@endpush

@endsection
