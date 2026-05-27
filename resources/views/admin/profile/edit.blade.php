@extends('layouts.admin')
@section('title', 'My Profile')

@section('breadcrumb')
    <span class="topbar-breadcrumb-item">System</span>
    <span class="topbar-breadcrumb-sep">/</span>
    <span class="topbar-breadcrumb-item current">My Profile</span>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">My Profile</h1>
        <p class="page-subtitle">Update your information and change your password</p>
    </div>
</div>

<div class="admin-grid" style="grid-template-columns: 1fr; gap:16px;">
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <div class="admin-card-title">Profile Information</div>
                <div class="admin-card-subtitle">Update name and email</div>
            </div>
        </div>
        <div class="admin-card-body">
            <form method="POST" action="{{ route('admin.profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="admin-form-grid">
                    <div class="admin-form-group">
                        <label class="admin-label">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="admin-input" required>
                        @error('name')<div class="admin-help error">{{ $message }}</div>@enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="admin-input" required>
                        @error('email')<div class="admin-help error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div style="margin-top:14px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <div class="admin-card-title">Change Password</div>
                <div class="admin-card-subtitle">Enter your old password and a new password</div>
            </div>
        </div>
        <div class="admin-card-body">
            <form method="POST" action="{{ route('admin.profile.password') }}">
                @csrf
                @method('PATCH')

                <div class="admin-form-grid">
                    <div class="admin-form-group">
                        <label class="admin-label">Old Password</label>
                        <input type="password" name="old_password" class="admin-input" required autocomplete="current-password">
                        @error('old_password')<div class="admin-help error">{{ $message }}</div>@enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-label">New Password</label>
                        <input type="password" name="password" class="admin-input" required autocomplete="new-password">
                        @error('password')<div class="admin-help error">{{ $message }}</div>@enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="admin-input" required autocomplete="new-password">
                    </div>
                </div>

                <div style="margin-top:14px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-key"></i> Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

