{{-- FILE: resources/views/web/news/index.blade.php --}}
@extends('layouts.app')
@section('title', 'News & Updates')
@section('meta_description', 'Latest news, events and success stories from DDU BTIC — Dire Dawa University Business and Technology Incubation Center.')

@section('content')
<section class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <div class="section-tag section-tag--on-dark">
                <i class="fas fa-newspaper"></i> News & Blog
            </div>
            <h1 class="page-hero-title">Stories from the BTIC Ecosystem</h1>
            <p class="page-hero-sub">Announcements, success stories, events and insights from Dire Dawa University's incubation community.</p>
            <div class="breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span><span class="current">News</span></div>
        </div>
    </div>
</section>

<section class="section section-light">
    <div class="container">

        {{-- Featured Articles --}}
        @if($featured->count() > 0 && !request()->hasAny(['search','category']))
        <div style="margin-bottom:56px;">
            <div class="section-tag" style="margin-bottom:20px;"><i class="fas fa-star"></i> Featured</div>
            <div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;">
                @php $mainFeatured = $featured->first(); $sideFeatured = $featured->skip(1); @endphp
                <a href="{{ route('news.show',$mainFeatured->slug) }}" style="background:white;border-radius:var(--radius-xl);overflow:hidden;border:1px solid var(--light-gray);transition:var(--transition);display:block;" class="news-card">
                    <div style="height:280px;background:linear-gradient(135deg,var(--navy),var(--crimson));position:relative;overflow:hidden;">
                        @if($mainFeatured->cover_image)
                            <img src="{{ asset('storage/'.$mainFeatured->cover_image) }}" alt="{{ $mainFeatured->title }}" style="width:100%;height:100%;object-fit:cover;opacity:0.7;">
                        @endif
                        @if($mainFeatured->category)<span class="news-category-tag">{{ $mainFeatured->category }}</span>@endif
                    </div>
                    <div style="padding:28px;">
                        <div class="news-meta">
                            <span class="news-date"><i class="fas fa-calendar" style="margin-right:4px;"></i>{{ $mainFeatured->published_at?->format('M d, Y') }}</span>
                            <span class="news-read-time">· {{ $mainFeatured->reading_time }}</span>
                        </div>
                        <h2 style="font-size:1.4rem;font-weight:700;color:var(--text-dark);line-height:1.35;margin-bottom:10px;">{{ $mainFeatured->title }}</h2>
                        @if($mainFeatured->excerpt)<p style="color:var(--text-body);line-height:1.7;font-size:0.9rem;">{{ $mainFeatured->excerpt }}</p>@endif
                        <div style="margin-top:16px;font-size:0.85rem;font-weight:600;color:var(--crimson);">Read Full Story →</div>
                    </div>
                </a>
                <div style="display:flex;flex-direction:column;gap:16px;">
                    @foreach($sideFeatured as $article)
                    <a href="{{ route('news.show',$article->slug) }}" class="news-card" style="flex:1;display:flex;flex-direction:column;">
                        <div class="news-card-img" style="height:130px;flex-shrink:0;">
                            @if($article->cover_image)
                                <img src="{{ asset('storage/'.$article->cover_image) }}" alt="{{ $article->title }}">
                            @else
                                <div style="width:100%;height:100%;background:linear-gradient(135deg,var(--light-gray),var(--off-white));display:flex;align-items:center;justify-content:center;"><i class="fas fa-newspaper" style="font-size:2rem;color:var(--mid-gray);opacity:0.4;"></i></div>
                            @endif
                            @if($article->category)<span class="news-category-tag" style="font-size:0.65rem;">{{ $article->category }}</span>@endif
                        </div>
                        <div class="news-card-body" style="flex:1;">
                            <div class="news-meta" style="margin-bottom:6px;">
                                <span class="news-date">{{ $article->published_at?->format('M d, Y') }}</span>
                            </div>
                            <h3 class="news-title" style="font-size:0.9rem;">{{ $article->title }}</h3>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Filter --}}
        <form method="GET" class="filter-bar" style="margin-bottom:32px;">
            <div class="filter-search">
                <i class="fas fa-search filter-search-icon"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search articles...">
            </div>
            <select name="category" class="filter-select" data-auto-submit>
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Search</button>
            @if(request()->hasAny(['search','category']))
                <a href="{{ route('news.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-times"></i> Clear</a>
            @endif
        </form>

        @if($news->count() > 0)
            <div class="news-grid">
                @foreach($news as $article)
                <a href="{{ route('news.show',$article->slug) }}" class="news-card">
                    <div class="news-card-img">
                        @if($article->cover_image)
                            <img src="{{ asset('storage/'.$article->cover_image) }}" alt="{{ $article->title }}">
                        @else
                            <div style="width:100%;height:100%;background:linear-gradient(135deg,var(--light-gray),var(--off-white));display:flex;align-items:center;justify-content:center;"><i class="fas fa-newspaper" style="font-size:2.5rem;color:var(--mid-gray);opacity:0.4;"></i></div>
                        @endif
                        @if($article->category)<span class="news-category-tag">{{ $article->category }}</span>@endif
                    </div>
                    <div class="news-card-body">
                        <div class="news-meta">
                            <span class="news-date"><i class="fas fa-calendar" style="margin-right:4px;"></i>{{ $article->published_at?->format('M d, Y') }}</span>
                            <span class="news-read-time">· {{ $article->reading_time }}</span>
                        </div>
                        <h3 class="news-title">{{ $article->title }}</h3>
                        @if($article->excerpt)<p class="news-excerpt">{{ $article->excerpt }}</p>@endif
                        <div class="news-card-footer">
                            <div class="news-author">
                                <div class="news-author-avatar">{{ strtoupper(substr($article->author->name ?? 'A',0,1)) }}</div>
                                <span class="news-author-name">{{ $article->author->name ?? 'BTIC Team' }}</span>
                            </div>
                            <span style="font-size:0.78rem;color:var(--crimson);font-weight:600;">Read →</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @if($news->hasPages())<div class="pagination-wrapper">{{ $news->links() }}</div>@endif
        @else
            <div style="text-align:center;padding:64px 24px;">
                <i class="fas fa-newspaper" style="font-size:3rem;color:var(--mid-gray);opacity:0.3;margin-bottom:20px;display:block;"></i>
                <h3 style="font-size:1.2rem;font-weight:700;color:var(--text-dark);">No articles found</h3>
                <p style="color:var(--text-body);margin-top:8px;"><a href="{{ route('news.index') }}" style="color:var(--crimson);">Clear filters</a> to see all articles.</p>
            </div>
        @endif
    </div>
</section>
@endsection
