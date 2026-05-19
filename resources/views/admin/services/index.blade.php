{{-- FILE: resources/views/admin/services/index.blade.php --}}
@extends('layouts.admin')
@section('title','Services')
@section('breadcrumb')<span class="topbar-breadcrumb-item current">Services</span>@endsection

@section('content')
<div class="page-header">
    <div><h1 class="page-title">Services</h1><p class="page-subtitle">Manage support services shown on the website</p></div>
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Service</a>
</div>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr><th>Service</th><th>Category</th><th>Features</th><th>Status</th><th>Order</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($services as $service)
            <tr>
                <td>
                    <div class="td-avatar">
                        <div class="td-avatar-placeholder" style="background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));border-radius:var(--radius-sm);">
                            <i class="fas {{ $service->icon ?? 'fa-star' }}" style="font-size:0.85rem;"></i>
                        </div>
                        <div>
                            <div class="td-name">{{ $service->title }}</div>
                            <div class="td-sub">{{ Str::limit($service->description, 50) }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    @if($service->category)
                        <span class="badge badge-primary">{{ $service->category }}</span>
                    @else
                        <span class="muted">—</span>
                    @endif
                </td>
                <td class="muted">{{ $service->features ? count($service->features).' items' : '—' }}</td>
                <td>
                    @if($service->is_active)
                        <span class="badge badge-success badge-dot">Active</span>
                    @else
                        <span class="badge badge-secondary">Hidden</span>
                    @endif
                </td>
                <td class="muted">{{ $service->sort_order }}</td>
                <td>
                    <div class="td-actions">
                        <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-xs btn-secondary"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('Delete this service?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6">
                <div class="empty-state">
                    <div class="empty-state-icon"><i class="fas fa-concierge-bell"></i></div>
                    <div class="empty-state-title">No services yet</div>
                    <a href="{{ route('admin.services.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add First Service</a>
                </div>
            </td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($services->hasPages())<div style="margin-top:20px;">{{ $services->links() }}</div>@endif
@endsection
