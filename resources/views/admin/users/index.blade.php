@extends('layouts.admin')
@section('title', 'User Management')

@section('breadcrumb')
    <span class="topbar-breadcrumb-item">System</span>
    <span class="topbar-breadcrumb-sep">/</span>
    <span class="topbar-breadcrumb-item current">User Management</span>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">User Management</h1>
        <p class="page-subtitle">Create, edit, and deactivate admin accounts</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> New User
        </a>
    </div>
</div>

<div class="admin-filter-bar">
    <form method="GET" style="display:contents;">
        <div class="admin-search-input">
            <i class="fas fa-search admin-search-icon"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email...">
        </div>
        <select name="role" class="admin-filter-select" onchange="this.form.submit()">
            <option value="">All Roles</option>
            <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="editor" {{ request('role') === 'editor' ? 'selected' : '' }}>Editor</option>
        </select>
        <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-search"></i> Search</button>
        @if(request()->hasAny(['search','role']))
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i> Clear</a>
        @endif
    </form>
</div>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>User</th>
                <th>Role</th>
                <th>Status</th>
                <th>Last Login</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>
                    <div class="td-avatar">
                        <div class="td-avatar-placeholder">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                        <div>
                            <div class="td-name">{{ $user->name }}</div>
                            <div class="td-sub">{{ $user->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="muted">{{ str_replace('_',' ', $user->role) }}</td>
                <td>
                    @if($user->is_active)
                        <span class="badge badge-success badge-dot">Active</span>
                    @else
                        <span class="badge badge-secondary">Inactive</span>
                    @endif
                </td>
                <td class="muted">{{ $user->last_login_at ? $user->last_login_at->format('M d, Y H:i') : '—' }}</td>
                <td class="muted">{{ $user->created_at->format('M d, Y') }}</td>
                <td>
                    <div class="td-actions">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-xs btn-secondary" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Soft-delete this user?')" >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-danger" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <div class="empty-state-icon"><i class="fas fa-users"></i></div>
                        <div class="empty-state-title">No users found</div>
                        <div class="empty-state-desc">Create a new admin user to get started.</div>
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Create User
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($users->hasPages())
<div class="pagination-wrapper" style="margin-top:20px;">
    {{ $users->links() }}
</div>
@endif

<div style="height:20px;"></div>

<div class="page-header" style="margin-bottom:14px;">
    <div>
        <h2 class="page-title" style="font-size:1.15rem;">Deleted Users</h2>
        <p class="page-subtitle">Restore soft-deleted accounts</p>
    </div>
</div>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>User</th>
                <th>Role</th>
                <th>Deleted At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($deletedUsers as $du)
            <tr>
                <td>
                    <div class="td-avatar">
                        <div class="td-avatar-placeholder">{{ strtoupper(substr($du->name, 0, 2)) }}</div>
                        <div>
                            <div class="td-name">{{ $du->name }}</div>
                            <div class="td-sub">{{ $du->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="muted">{{ str_replace('_',' ', $du->role) }}</td>
                <td class="muted">{{ $du->deleted_at?->format('M d, Y H:i') ?? '—' }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.users.restore', $du->id) }}" onsubmit="return confirm('Restore this user?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-xs btn-success">
                            <i class="fas fa-undo"></i> Restore
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">
                    <div class="empty-state" style="padding:40px 24px;">
                        <div class="empty-state-icon"><i class="fas fa-user-slash"></i></div>
                        <div class="empty-state-title">No deleted users</div>
                        <div class="empty-state-desc">Soft-deleted accounts will appear here.</div>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($deletedUsers->hasPages())
<div class="pagination-wrapper" style="margin-top:20px;">
    {{ $deletedUsers->links() }}
</div>
@endif
@endsection

