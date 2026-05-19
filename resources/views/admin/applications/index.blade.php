@extends('layouts.admin')
@section('title', 'Applications')
@section('breadcrumb')
    <span class="topbar-breadcrumb-item current">Applications</span>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Startup Applications</h1>
        <p class="page-subtitle">Review and manage incubation applications</p>
    </div>
    <a href="{{ route('admin.cohorts.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-layer-group"></i> Manage Cohorts
    </a>
</div>

{{-- Status Tabs --}}
<div style="display:flex;gap:8px;margin-bottom:20px;flex-wrap:wrap;">
    @php
        $statuses = ['all'=>'All','pending'=>'Pending','under_review'=>'Under Review','shortlisted'=>'Shortlisted','approved'=>'Approved','rejected'=>'Rejected'];
        $colors   = ['all'=>'badge-secondary','pending'=>'badge-warning','under_review'=>'badge-info','shortlisted'=>'badge-purple','approved'=>'badge-success','rejected'=>'badge-danger'];
    @endphp
    @foreach($statuses as $key => $label)
    <a href="{{ route('admin.applications.index', array_merge(request()->except('status','page'), ['status' => $key === 'all' ? '' : $key])) }}"
       style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:0.82rem;font-weight:600;border:1.5px solid;transition:all 0.2s;
              {{ (request('status','') === ($key === 'all' ? '' : $key)) ? 'background:var(--crimson);color:white;border-color:var(--crimson);' : 'background:white;color:var(--text-body);border-color:var(--border);' }}">
        {{ $label }}
        <span style="background:rgba(0,0,0,0.15);color:inherit;border-radius:100px;padding:1px 7px;font-size:0.7rem;">
            {{ $statusCounts[$key === 'all' ? 'all' : $key] ?? 0 }}
        </span>
    </a>
    @endforeach
</div>

{{-- Filters --}}
<div class="admin-filter-bar">
    <form method="GET" style="display:contents;">
        <input type="hidden" name="status" value="{{ request('status') }}">
        <div class="admin-search-input">
            <i class="fas fa-search admin-search-icon"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by startup, founder, or ref #...">
        </div>
        <select name="cohort_id" class="admin-filter-select" onchange="this.form.submit()">
            <option value="">All Cohorts</option>
            @foreach($cohorts as $cohort)
                <option value="{{ $cohort->id }}" {{ request('cohort_id') == $cohort->id ? 'selected' : '' }}>{{ $cohort->name }}</option>
            @endforeach
        </select>
        <select name="sector" class="admin-filter-select" onchange="this.form.submit()">
            <option value="">All Sectors</option>
            @foreach($sectors as $sector)
                <option value="{{ $sector }}" {{ request('sector') === $sector ? 'selected' : '' }}>{{ $sector }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-filter"></i> Filter</button>
    </form>
</div>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Startup</th>
                <th>Cohort</th>
                <th>Sector / Stage</th>
                <th>Founder</th>
                <th>Team</th>
                <th>Status</th>
                <th>Applied</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $app)
            <tr>
                <td>
                    <div>
                        <div class="td-name">{{ $app->startup_name }}</div>
                        <div class="td-sub" style="font-family:var(--font-mono);letter-spacing:0.05em;">{{ $app->reference_number }}</div>
                    </div>
                </td>
                <td class="muted">{{ $app->cohort->name ?? '—' }}</td>
                <td>
                    <div><span class="badge badge-primary">{{ $app->sector }}</span></div>
                    <div style="margin-top:4px;font-size:0.72rem;color:var(--text-muted);">{{ ucfirst(str_replace('_',' ',$app->stage)) }}</div>
                </td>
                <td>
                    <div class="td-name" style="font-weight:500;">{{ $app->founder_name }}</div>
                    <div class="td-sub">{{ $app->founder_email }}</div>
                </td>
                <td class="muted">{{ $app->team_size }} {{ $app->team_size === 1 ? 'person' : 'people' }}</td>
                <td>
                    <span class="badge {{ $app->status_badge_class }}">{{ $app->status_label }}</span>
                </td>
                <td class="muted">{{ $app->created_at->format('M d, Y') }}</td>
                <td>
                    <div class="td-actions">
                        <a href="{{ route('admin.applications.show', $app) }}" class="btn btn-xs btn-secondary" title="View Details">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.applications.destroy', $app) }}" onsubmit="return confirm('Delete this application?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8">
                    <div class="empty-state">
                        <div class="empty-state-icon"><i class="fas fa-file-alt"></i></div>
                        <div class="empty-state-title">No applications found</div>
                        <div class="empty-state-desc">Applications will appear here when startups apply through the website.</div>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($applications->hasPages())
<div style="margin-top:20px;">{{ $applications->links() }}</div>
@endif
@endsection
