@extends('layouts.admin')
@section('title', 'Partners')
@section('breadcrumb')<span class="topbar-breadcrumb-item current">Partners</span>@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Partners & Collaborators</h1>
        <p class="page-subtitle">Manage partnership logos displayed on the homepage</p>
    </div>
    <a href="{{ route('admin.partners.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Partner</a>
</div>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Partner</th>
                <th>Website</th>
                <th>Status</th>
                <th>Order</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($partners as $partner)
            <tr>
                <td>
                    <div class="td-avatar">
                        @if($partner->logo)
                            <img src="{{ asset('storage/'.$partner->logo) }}" alt="" class="td-avatar-img" style="border-radius:50%;object-fit:cover;">
                        @else
                            <div class="td-avatar-placeholder" style="border-radius:50%;">{{ strtoupper(substr($partner->name, 0, 1)) }}</div>
                        @endif
                        <div>
                            <div class="td-name">{{ $partner->name }}</div>
                            @if($partner->description)
                                <div class="muted" style="font-size:0.75rem;max-width:280px;">{{ Str::limit($partner->description, 60) }}</div>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="muted" style="font-size:0.78rem;">
                    @if($partner->website_url)
                        <a href="{{ $partner->website_url }}" target="_blank" rel="noopener">{{ parse_url($partner->website_url, PHP_URL_HOST) }}</a>
                    @else
                        —
                    @endif
                </td>
                <td>
                    @if($partner->is_active)
                        <span class="badge badge-success badge-dot">Active</span>
                    @else
                        <span class="badge badge-secondary">Hidden</span>
                    @endif
                </td>
                <td class="muted">{{ $partner->sort_order }}</td>
                <td>
                    <div class="td-actions">
                        <a href="{{ route('admin.partners.edit', $partner) }}" class="btn btn-xs btn-secondary"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{ route('admin.partners.destroy', $partner) }}" onsubmit="return confirm('Remove this partner?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">
                    <div class="empty-state">
                        <div class="empty-state-icon"><i class="fas fa-handshake"></i></div>
                        <div class="empty-state-title">No partners yet</div>
                        <a href="{{ route('admin.partners.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add First Partner</a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($partners->hasPages())
    <div style="margin-top:20px;">{{ $partners->links() }}</div>
@endif
@endsection
