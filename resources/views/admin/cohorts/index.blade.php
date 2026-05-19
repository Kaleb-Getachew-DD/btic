{{-- FILE: resources/views/admin/cohorts/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Cohorts')
@section('breadcrumb')<span class="topbar-breadcrumb-item current">Cohorts</span>@endsection

@section('content')
<div class="page-header">
    <div><h1 class="page-title">Cohort Management</h1><p class="page-subtitle">Manage incubation cohorts and application windows</p></div>
    <a href="{{ route('admin.cohorts.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> New Cohort</a>
</div>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead><tr><th>Cohort</th><th>Batch #</th><th>Application Window</th><th>Spots</th><th>Applications</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($cohorts as $cohort)
            <tr>
                <td><div class="td-name">{{ $cohort->name }}</div><div class="td-sub">{{ Str::limit($cohort->description, 60) }}</div></td>
                <td><span class="badge badge-navy" style="background:rgba(28,40,84,0.1);color:var(--navy);">Batch {{ $cohort->batch_number }}</span></td>
                <td class="muted" style="font-size:0.8rem;">
                    {{ $cohort->application_start->format('M d') }} – {{ $cohort->application_end->format('M d, Y') }}
                </td>
                <td class="muted">{{ $cohort->max_startups }}</td>
                <td>
                    <span style="font-size:0.875rem;font-weight:700;color:var(--text-dark);">{{ $cohort->applications_count }}</span>
                    <span style="font-size:0.75rem;color:var(--text-muted);"> / {{ $cohort->max_startups }}</span>
                </td>
                <td>
                    <span class="badge {{ ['upcoming'=>'badge-warning','open'=>'badge-success','closed'=>'badge-secondary','active'=>'badge-info','completed'=>'badge-purple'][$cohort->status] ?? 'badge-secondary' }}">
                        {{ ucfirst($cohort->status) }}
                    </span>
                </td>
                <td>
                    <div class="td-actions">
                        <form method="POST" action="{{ route('admin.cohorts.toggle-status', $cohort) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-xs btn-secondary" title="Advance Status"><i class="fas fa-step-forward"></i></button>
                        </form>
                        <a href="{{ route('admin.cohorts.edit', $cohort) }}" class="btn btn-xs btn-secondary"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('admin.applications.index', ['cohort_id' => $cohort->id]) }}" class="btn btn-xs btn-secondary" title="View Applications"><i class="fas fa-file-alt"></i></a>
                        <form method="POST" action="{{ route('admin.cohorts.destroy', $cohort) }}" onsubmit="return confirm('Delete this cohort?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7"><div class="empty-state"><div class="empty-state-icon"><i class="fas fa-layer-group"></i></div><div class="empty-state-title">No cohorts yet</div><a href="{{ route('admin.cohorts.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Create First Cohort</a></div></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($cohorts->hasPages())<div style="margin-top:20px;">{{ $cohorts->links() }}</div>@endif
@endsection
