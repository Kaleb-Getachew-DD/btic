@extends('layouts.admin')
@section('title', 'Dashboard')
@section('breadcrumb')
    <span class="topbar-breadcrumb-item current">Dashboard</span>
@endsection

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Welcome back, {{ auth()->user()->name }} — {{ now()->format('l, F j, Y') }}</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('admin.applications.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-file-alt"></i> View Applications
        </a>
        <a href="{{ route('admin.startups.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add Startup
        </a>
    </div>
</div>

{{-- ===== STAT CARDS ===== --}}
<div class="dashboard-stats">
    <div class="stat-card">
        <div class="stat-card-stripe red"></div>
        <div class="stat-card-icon red"><i class="fas fa-file-alt"></i></div>
        <div class="stat-card-value">{{ number_format($stats['total_applications']) }}</div>
        <div class="stat-card-label">Total Applications</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-stripe orange"></div>
        <div class="stat-card-icon orange"><i class="fas fa-clock"></i></div>
        <div class="stat-card-value">{{ number_format($stats['pending_applications']) }}</div>
        <div class="stat-card-label">Pending Review</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-stripe green"></div>
        <div class="stat-card-icon green"><i class="fas fa-check-circle"></i></div>
        <div class="stat-card-value">{{ number_format($stats['approved_applications']) }}</div>
        <div class="stat-card-label">Approved</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-stripe blue"></div>
        <div class="stat-card-icon blue"><i class="fas fa-rocket"></i></div>
        <div class="stat-card-value">{{ number_format($stats['total_startups']) }}</div>
        <div class="stat-card-label">Active Startups</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-stripe navy"></div>
        <div class="stat-card-icon navy"><i class="fas fa-newspaper"></i></div>
        <div class="stat-card-value">{{ number_format($stats['total_news']) }}</div>
        <div class="stat-card-label">Published Articles</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-stripe gold"></div>
        <div class="stat-card-icon gold"><i class="fas fa-layer-group"></i></div>
        <div class="stat-card-value">{{ number_format($stats['active_cohorts']) }}</div>
        <div class="stat-card-label">Active Cohorts</div>
    </div>
</div>

{{-- ===== CHARTS ===== --}}
<div class="dashboard-grid" style="margin-bottom:20px;">
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <div class="admin-card-title">Applications by Sector</div>
                <div class="admin-card-sub">Top sectors represented in applications</div>
            </div>
        </div>
        <div class="admin-card-body" style="padding:20px;">
            <canvas id="sectorChart" height="220"
                data-values="{{ json_encode($applicationsBySector) }}"></canvas>
        </div>
    </div>
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <div class="admin-card-title">Status Breakdown</div>
                <div class="admin-card-sub">Current application pipeline</div>
            </div>
        </div>
        <div class="admin-card-body" style="padding:20px;">
            <canvas id="statusChart" height="220"
                data-values="{{ json_encode($applicationsByStatus) }}"></canvas>
        </div>
    </div>
</div>

{{-- ===== RECENT APPLICATIONS + NOTIFICATIONS ===== --}}
<div class="dashboard-grid">
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <div class="admin-card-title">Recent Applications</div>
                <div class="admin-card-sub">Latest startup applications</div>
            </div>
            <a href="{{ route('admin.applications.index') }}" class="btn btn-secondary btn-sm">View All</a>
        </div>
        @if($recentApplications->count() > 0)
        <div class="admin-table-wrapper" style="border:none;border-radius:0;box-shadow:none;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Startup</th>
                        <th>Cohort</th>
                        <th>Sector</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentApplications as $app)
                    <tr>
                        <td>
                            <div class="td-avatar">
                                <div class="td-avatar-placeholder">{{ strtoupper(substr($app->startup_name, 0, 2)) }}</div>
                                <div>
                                    <div class="td-name">{{ $app->startup_name }}</div>
                                    <div class="td-sub">{{ $app->founder_name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="muted">{{ $app->cohort->name ?? '—' }}</td>
                        <td><span class="badge badge-primary">{{ $app->sector }}</span></td>
                        <td>
                            <span class="badge {{ $app->status_badge_class }}">
                                {{ $app->status_label }}
                            </span>
                        </td>
                        <td class="muted">{{ $app->created_at->format('M d') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-state-icon"><i class="fas fa-file-alt"></i></div>
            <div class="empty-state-title">No applications yet</div>
            <div class="empty-state-desc">Applications will appear here once startups start applying.</div>
        </div>
        @endif
    </div>

    <div>
        {{-- Notifications --}}
        <div class="admin-card" style="margin-bottom:20px;">
            <div class="admin-card-header">
                <div>
                    <div class="admin-card-title">Recent Notifications</div>
                </div>
                <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary btn-sm">View All</a>
            </div>
            @if($notifications->count() > 0)
            @foreach($notifications as $notif)
            <div class="notification-item unread">
                <div class="notification-icon {{ $notif->icon_color === 'text-primary' ? 'red' : ($notif->icon_color === 'text-success' ? 'green' : 'yellow') }}">
                    <i class="fas {{ $notif->icon }}"></i>
                </div>
                <div class="notification-body">
                    <div class="notification-title">{{ $notif->title }}</div>
                    <div class="notification-message">{{ Str::limit($notif->message, 60) }}</div>
                    <div class="notification-time">{{ $notif->created_at->diffForHumans() }}</div>
                </div>
            </div>
            @endforeach
            @else
            <div style="padding:24px;text-align:center;color:var(--text-muted);font-size:0.85rem;">
                No new notifications
            </div>
            @endif
        </div>

        {{-- Open Cohorts --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-title">Active Cohorts</div>
                <a href="{{ route('admin.cohorts.index') }}" class="btn btn-secondary btn-sm">Manage</a>
            </div>
            @foreach($openCohorts as $cohort)
            <div style="padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;gap:12px;">
                <div>
                    <div style="font-size:0.875rem;font-weight:600;color:var(--text-dark);">{{ $cohort->name }}</div>
                    <div style="font-size:0.75rem;color:var(--text-muted);">
                        Closes {{ $cohort->application_end->format('M d, Y') }}
                        · {{ $cohort->applications_count }} applications
                    </div>
                </div>
                <span class="badge {{ $cohort->status === 'open' ? 'badge-success' : 'badge-warning' }}">
                    {{ ucfirst($cohort->status) }}
                </span>
            </div>
            @endforeach
            @if($openCohorts->count() === 0)
                <div style="padding:20px;text-align:center;font-size:0.85rem;color:var(--text-muted);">No active cohorts</div>
            @endif
        </div>
    </div>
</div>

@endsection
