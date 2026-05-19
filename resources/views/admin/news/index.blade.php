{{-- FILE: resources/views/admin/news/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'News Management')
@section('breadcrumb')
    <span class="topbar-breadcrumb-item">Content</span>
    <span class="topbar-breadcrumb-sep">/</span>
    <span class="topbar-breadcrumb-item current">News & Blog</span>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">News & Blog</h1>
        <p class="page-subtitle">Manage all news articles and blog posts</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Article
        </a>
    </div>
</div>

<div class="admin-filter-bar">
    <form method="GET" style="display:contents;">
        <div class="admin-search-input">
            <i class="fas fa-search admin-search-icon"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search articles...">
        </div>
        <select name="category" class="admin-filter-select" onchange="this.form.submit()">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>
        <select name="status" class="admin-filter-select" onchange="this.form.submit()">
            <option value="">All Status</option>
            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
        </select>
        <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-search"></i> Search</button>
        @if(request()->hasAny(['search','category','status']))
            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i> Clear</a>
        @endif
    </form>
</div>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Article</th>
                <th>Category</th>
                <th>Author</th>
                <th>Status</th>
                <th>Views</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($news as $article)
            <tr>
                <td>
                    <div class="td-avatar">
                        @if($article->cover_image)
                            <img src="{{ asset('storage/'.$article->cover_image) }}" alt="" class="td-avatar-img" style="border-radius:6px;">
                        @else
                            <div class="td-avatar-placeholder" style="border-radius:6px;"><i class="fas fa-newspaper" style="font-size:0.8rem;"></i></div>
                        @endif
                        <div>
                            <div class="td-name truncate" style="max-width:280px;">{{ $article->title }}</div>
                            <div class="td-sub">{{ $article->slug }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    @if($article->category)
                        <span class="badge badge-primary">{{ $article->category }}</span>
                    @else
                        <span class="muted">—</span>
                    @endif
                </td>
                <td class="muted">{{ $article->author->name ?? '—' }}</td>
                <td>
                    @if($article->is_published)
                        <span class="badge badge-success badge-dot">Published</span>
                    @else
                        <span class="badge badge-secondary">Draft</span>
                    @endif
                    @if($article->is_featured)
                        <span class="badge badge-warning" style="margin-left:4px;">⭐ Featured</span>
                    @endif
                </td>
                <td class="muted">{{ number_format($article->views) }}</td>
                <td class="muted">{{ $article->published_at ? $article->published_at->format('M d, Y') : $article->created_at->format('M d, Y') }}</td>
                <td>
                    <div class="td-actions">
                        <form method="POST" action="{{ route('admin.news.toggle-publish', $article) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-xs {{ $article->is_published ? 'btn-secondary' : 'btn-success' }}" title="{{ $article->is_published ? 'Unpublish' : 'Publish' }}">
                                <i class="fas {{ $article->is_published ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                            </button>
                        </form>
                        <a href="{{ route('admin.news.edit', $article) }}" class="btn btn-xs btn-secondary"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{ route('admin.news.destroy', $article) }}" onsubmit="return confirm('Delete this article?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">
                    <div class="empty-state">
                        <div class="empty-state-icon"><i class="fas fa-newspaper"></i></div>
                        <div class="empty-state-title">No articles found</div>
                        <div class="empty-state-desc">Create your first news article to get started.</div>
                        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create Article
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($news->hasPages())
<div class="pagination-wrapper" style="margin-top:20px;">
    {{ $news->links() }}
</div>
@endif
@endsection
