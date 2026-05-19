{{-- FILE: resources/views/admin/programs/index.blade.php --}}
@extends('layouts.admin')
@section('title','Programs')
@section('breadcrumb')<span class="topbar-breadcrumb-item current">Programs</span>@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Programs</h1>
        <p class="page-subtitle">Manage incubation programs displayed on the website</p>
    </div>
    <a href="{{ route('admin.programs.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Program
    </a>
</div>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Program</th>
                <th>Duration</th>
                <th>Benefits</th>
                <th>Status</th>
                <th>Order</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($programs as $program)
            <tr>
                <td>
                    <div class="td-avatar">
                        <div class="td-avatar-placeholder" style="background:linear-gradient(135deg,var(--crimson),var(--navy));border-radius:var(--radius-sm);">
                            <i class="fas {{ $program->icon ?? 'fa-rocket' }}" style="font-size:0.85rem;"></i>
                        </div>
                        <div>
                            <div class="td-name">{{ $program->title }}</div>
                            <div class="td-sub">{{ Str::limit($program->short_description, 55) }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    @if($program->duration)
                        <span class="badge badge-info">{{ $program->duration }}</span>
                    @else
                        <span class="muted">—</span>
                    @endif
                </td>
                <td class="muted">
                    {{ $program->benefits ? count($program->benefits) . ' benefits' : '—' }}
                </td>
                <td>
                    @if($program->is_active)
                        <span class="badge badge-success badge-dot">Active</span>
                    @else
                        <span class="badge badge-secondary">Hidden</span>
                    @endif
                </td>
                <td class="muted">{{ $program->sort_order }}</td>
                <td>
                    <div class="td-actions">
                        <a href="{{ route('admin.programs.edit', $program) }}" class="btn btn-xs btn-secondary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.programs.destroy', $program) }}"
                            onsubmit="return confirm('Delete this program?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <div class="empty-state-icon"><i class="fas fa-graduation-cap"></i></div>
                        <div class="empty-state-title">No programs yet</div>
                        <a href="{{ route('admin.programs.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create First Program
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($programs->hasPages())
    <div style="margin-top:20px;">{{ $programs->links() }}</div>
@endif
@endsection
