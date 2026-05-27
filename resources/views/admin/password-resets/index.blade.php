@extends('layouts.admin')
@section('title', 'Password Reset Requests')

@section('breadcrumb')
    <span class="topbar-breadcrumb-item">System</span>
    <span class="topbar-breadcrumb-sep">/</span>
    <span class="topbar-breadcrumb-item current">Password Requests</span>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Password Reset Requests</h1>
        <p class="page-subtitle">User-submitted requests that require an admin to set a new custom password</p>
    </div>
</div>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Email</th>
                <th>User</th>
                <th>Status</th>
                <th>Requested</th>
                <th>Resolved</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $req)
            <tr>
                <td>
                    <div class="td-name">{{ $req->email }}</div>
                    <div class="td-sub">#{{ $req->id }}</div>
                </td>
                <td class="muted">
                    {{ $req->user?->name ?? '—' }}
                </td>
                <td>
                    @if($req->status === 'resolved')
                        <span class="badge badge-success badge-dot">Resolved</span>
                    @else
                        <span class="badge badge-warning">Pending</span>
                    @endif
                </td>
                <td class="muted">{{ $req->created_at->format('M d, Y H:i') }}</td>
                <td class="muted">
                    @if($req->resolved_at)
                        {{ $req->resolved_at->format('M d, Y H:i') }} ({{ $req->resolver?->name ?? '—' }})
                    @else
                        —
                    @endif
                </td>
                <td>
                    @if($req->status === 'pending')
                        <form method="POST" action="{{ route('admin.password-resets.resolve', $req) }}" style="display:flex;gap:8px;align-items:flex-start;flex-wrap:wrap;">
                            @csrf
                            @method('PATCH')
                            <input type="password" name="password" class="admin-input" placeholder="New password" style="max-width:180px;" required>
                            <input type="password" name="password_confirmation" class="admin-input" placeholder="Confirm" style="max-width:180px;" required>
                            <button type="submit" class="btn btn-xs btn-success">
                                <i class="fas fa-check"></i> Set Password
                            </button>
                        </form>
                    @else
                        <span class="muted">—</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <div class="empty-state-icon"><i class="fas fa-key"></i></div>
                        <div class="empty-state-title">No reset requests</div>
                        <div class="empty-state-desc">When users submit “Forgot password”, requests will appear here.</div>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($requests->hasPages())
<div class="pagination-wrapper" style="margin-top:20px;">
    {{ $requests->links() }}
</div>
@endif
@endsection

