{{-- FILE: resources/views/admin/team/create.blade.php --}}
@extends('layouts.admin')
@section('title','Add Team Member')
@section('breadcrumb')
    <span class="topbar-breadcrumb-item"><a href="{{ route('admin.team.index') }}">Team</a></span>
    <span class="topbar-breadcrumb-sep">/</span>
    <span class="topbar-breadcrumb-item current">Add Member</span>
@endsection
@section('content')
<div class="page-header">
    <h1 class="page-title">Add Team Member</h1>
    <a href="{{ route('admin.team.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
</div>
<form method="POST" action="{{ route('admin.team.store') }}" enctype="multipart/form-data">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;">
        <div class="admin-form-section">
            <div class="admin-form-section-header"><div class="admin-form-section-icon"><i class="fas fa-user"></i></div><div class="admin-form-section-title">Member Details</div></div>
            <div class="admin-form-section-body">
                <div class="form-grid">
                    <div class="form-group"><label class="form-label">Full Name <span class="required">*</span></label><input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required><div class="form-error">@error('name'){{ $message }}@enderror</div></div>
                    <div class="form-group"><label class="form-label">Job Title <span class="required">*</span></label><input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="e.g. Program Manager" required></div>
                    <div class="form-group"><label class="form-label">Department</label><input type="text" name="department" class="form-control" value="{{ old('department') }}" placeholder="e.g. Programs, Technology"></div>
                    <div class="form-group"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email') }}"></div>
                    <div class="form-group"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" value="{{ old('phone') }}"></div>
                    <div class="form-group"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0"><div class="form-hint">Lower number appears first</div></div>
                </div>
                <div class="form-group"><label class="form-label">Bio</label><textarea name="bio" class="form-control" rows="4" placeholder="Brief biography...">{{ old('bio') }}</textarea></div>
                <div class="form-grid">
                    <div class="form-group"><label class="form-label">LinkedIn URL</label><input type="url" name="linkedin" class="form-control" value="{{ old('linkedin') }}" placeholder="https://linkedin.com/in/..."></div>
                    <div class="form-group"><label class="form-label">Twitter URL</label><input type="url" name="twitter" class="form-control" value="{{ old('twitter') }}" placeholder="https://twitter.com/..."></div>
                </div>
                <div class="form-group">
                    <label class="form-toggle">
                        <div class="toggle-switch"><input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}><span class="toggle-slider"></span></div>
                        <span class="toggle-label">Show on website</span>
                    </label>
                </div>
            </div>
        </div>
        <div>
            <div class="admin-form-section" style="margin-bottom:16px;">
                <div class="admin-form-section-header"><div class="admin-form-section-icon"><i class="fas fa-image"></i></div><div class="admin-form-section-title">Photo</div></div>
                <div class="admin-form-section-body">
                    <div class="image-upload-area" onclick="this.querySelector('input').click()">
                        <input type="file" name="photo" accept="image/*" style="display:none;" data-preview="photoPreview">
                        <div class="image-upload-icon"><i class="fas fa-user-circle"></i></div>
                        <div class="image-upload-text">Upload profile photo</div>
                        <div class="image-upload-sub">JPG, PNG — Max 2MB, square preferred</div>
                        <img id="photoPreview" class="image-preview" style="display:none;border-radius:50%;width:100px;height:100px;object-fit:cover;margin:10px auto 0;">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;"><i class="fas fa-save"></i> Add Team Member</button>
        </div>
    </div>
</form>
@endsection
