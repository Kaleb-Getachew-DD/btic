{{-- FILE: resources/views/admin/startups/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Startups')
@section('breadcrumb')<span class="topbar-breadcrumb-item current">Startups Portfolio</span>@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Startups Portfolio</h1>
        <p class="page-subtitle">Manage incubated startups showcased on the website</p>
    </div>
    <a href="{{ route('admin.startups.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Startup
    </a>
</div>

<div class="admin-filter-bar">
    <form method="GET" style="display:contents;">
        <div class="admin-search-input">
            <i class="fas fa-search admin-search-icon"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search startups...">
        </div>
        <select name="sector" class="admin-filter-select" onchange="this.form.submit()">
            <option value="">All Sectors</option>
            @foreach($sectors as $sector)
                <option value="{{ $sector }}" {{ request('sector') === $sector ? 'selected' : '' }}>{{ $sector }}</option>
            @endforeach
        </select>
        <select name="featured" class="admin-filter-select" onchange="this.form.submit()">
            <option value="">All</option>
            <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>Featured Only</option>
        </select>
        <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-search"></i></button>
    </form>
</div>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr><th>Startup</th><th>Sector</th><th>Founder</th><th>Stage</th><th>Cohort</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($startups as $startup)
            <tr>
                <td>
                    <div class="td-avatar">
                        @if($startup->logo)
                            <img src="{{ asset('storage/'.$startup->logo) }}" alt="" class="td-avatar-img">
                        @else
                            <div class="td-avatar-placeholder">{{ strtoupper(substr($startup->name,0,2)) }}</div>
                        @endif
                        <div>
                            <div class="td-name">{{ $startup->name }}</div>
                            <div class="td-sub">{{ Str::limit($startup->tagline, 45) }}</div>
                        </div>
                    </div>
                </td>
                <td><span class="badge badge-primary">{{ $startup->sector }}</span></td>
                <td class="muted">{{ $startup->founder_name }}</td>
                <td class="muted">{{ ucfirst(str_replace('_',' ',$startup->stage)) }}</td>
                <td class="muted">{{ $startup->cohort_batch ?: '—' }}</td>
                <td>
                    @if($startup->is_featured)<span class="badge badge-warning" style="margin-right:4px;">⭐ Featured</span>@endif
                    @if($startup->is_active)<span class="badge badge-success badge-dot">Active</span>@else<span class="badge badge-secondary">Inactive</span>@endif
                </td>
                <td>
                    <div class="td-actions">
                        <form method="POST" action="{{ route('admin.startups.toggle-featured', $startup) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-xs btn-secondary" title="{{ $startup->is_featured ? 'Unfeature' : 'Feature' }}">
                                <i class="fas fa-star" style="{{ $startup->is_featured ? 'color:var(--gold)' : '' }}"></i>
                            </button>
                        </form>
                        <a href="{{ route('admin.startups.edit', $startup) }}" class="btn btn-xs btn-secondary"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('startups.show', $startup->slug) }}" class="btn btn-xs btn-secondary" target="_blank"><i class="fas fa-external-link-alt"></i></a>
                        <form method="POST" action="{{ route('admin.startups.destroy', $startup) }}" onsubmit="return confirm('Delete this startup?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7"><div class="empty-state"><div class="empty-state-icon"><i class="fas fa-rocket"></i></div><div class="empty-state-title">No startups found</div><a href="{{ route('admin.startups.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add First Startup</a></div></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($startups->hasPages())<div style="margin-top:20px;">{{ $startups->links() }}</div>@endif
@endsection
