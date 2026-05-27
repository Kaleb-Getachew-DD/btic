@extends('layouts.admin')
@section('title', 'Create User')

@section('breadcrumb')
    <span class="topbar-breadcrumb-item">System</span>
    <span class="topbar-breadcrumb-sep">/</span>
    <a class="topbar-breadcrumb-item" href="{{ route('admin.users.index') }}">User Management</a>
    <span class="topbar-breadcrumb-sep">/</span>
    <span class="topbar-breadcrumb-item current">Create</span>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Create User</h1>
        <p class="page-subtitle">Add a new admin/editor account</p>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-body">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="admin-form-grid">
                <div class="admin-form-group">
                    <label class="admin-label">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="admin-input" required>
                    @error('name')<div class="admin-help error">{{ $message }}</div>@enderror
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="admin-input" required>
                    @error('email')<div class="admin-help error">{{ $message }}</div>@enderror
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Role</label>
                    <select name="role" class="admin-input" required>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="editor" {{ old('role') === 'editor' ? 'selected' : '' }}>Editor</option>
                        <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                    @error('role')<div class="admin-help error">{{ $message }}</div>@enderror
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Active</label>
                    <select name="is_active" class="admin-input">
                        <option value="1" {{ old('is_active', '1') === '1' ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>No</option>
                    </select>
                    @error('is_active')<div class="admin-help error">{{ $message }}</div>@enderror
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Password</label>
                    <input type="password" name="password" class="admin-input" required autocomplete="new-password">
                    @error('password')<div class="admin-help error">{{ $message }}</div>@enderror
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="admin-input" required autocomplete="new-password">
                </div>
            </div>

            <div style="margin-top:14px; display:flex; gap:10px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create User
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

