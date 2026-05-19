@extends('layouts.admin')
@section('title','Edit Team Member')
@section('breadcrumb')
    <span class="topbar-breadcrumb-item"><a href="{{ route('admin.team.index') }}">Team</a></span>
    <span class="topbar-breadcrumb-sep">/</span>
    <span class="topbar-breadcrumb-item current">Edit</span>
@endsection

@section('content')
<div class="page-header">
    <div><h1 class="page-title">Edit: {{ $member->name }}</h1></div>
    <a href="{{ route('admin.team.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<form method="POST" action="{{ route('admin.team.update', $member) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;">
        <div class="admin-form-section">
            <div class="admin-form-section-header">
                <div class="admin-form-section-icon"><i class="fas fa-user"></i></div>
                <div class="admin-form-section-title">Member Details</div>
            </div>
            <div class="admin-form-section-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Full Name <span class="required">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $member->name) }}" required>
                        @error('name')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Job Title <span class="required">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $member->title) }}" required>
                        @error('title')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Department</label>
                        <input type="text" name="department" class="form-control"
                            value="{{ old('department', $member->department) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email', $member->email) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control"
                            value="{{ old('phone', $member->phone) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control"
                            value="{{ old('sort_order', $member->sort_order) }}" min="0">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Bio</label>
                    <textarea name="bio" class="form-control" rows="4">{{ old('bio', $member->bio) }}</textarea>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">LinkedIn URL</label>
                        <input type="url" name="linkedin" class="form-control"
                            value="{{ old('linkedin', $member->linkedin) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Twitter URL</label>
                        <input type="url" name="twitter" class="form-control"
                            value="{{ old('twitter', $member->twitter) }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-toggle">
                        <div class="toggle-switch">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active', $member->is_active) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </div>
                        <span class="toggle-label">Show on website</span>
                    </label>
                </div>
            </div>
        </div>

        <div>
            <div class="admin-form-section" style="margin-bottom:16px;">
                <div class="admin-form-section-header">
                    <div class="admin-form-section-icon"><i class="fas fa-image"></i></div>
                    <div class="admin-form-section-title">Profile Photo</div>
                </div>
                <div class="admin-form-section-body">
                    @if($member->photo)
                        <div style="text-align:center;margin-bottom:14px;">
                            <img src="{{ asset('storage/'.$member->photo) }}" alt="{{ $member->name }}"
                                style="width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid var(--border);box-shadow:var(--shadow-sm);">
                        </div>
                        <p style="font-size:0.75rem;color:var(--text-muted);text-align:center;margin-bottom:10px;">Upload new to replace</p>
                    @endif
                    <div class="image-upload-area" onclick="this.querySelector('input').click()">
                        <input type="file" name="photo" accept="image/*" style="display:none;" data-preview="photoPreview">
                        <div class="image-upload-icon"><i class="fas fa-camera"></i></div>
                        <div class="image-upload-text">{{ $member->photo ? 'Change photo' : 'Upload photo' }}</div>
                        <div class="image-upload-sub">JPG, PNG — Max 2MB</div>
                        <img id="photoPreview" class="image-preview"
                            style="display:none;border-radius:50%;width:80px;height:80px;object-fit:cover;margin:10px auto 0;">
                    </div>
                </div>
            </div>

            <div style="display:flex;gap:10px;">
                <button type="submit" class="btn btn-primary" style="flex:1;">
                    <i class="fas fa-save"></i> Update
                </button>
                </form>
                <form method="POST" action="{{ route('admin.team.destroy', $member) }}"
                    onsubmit="return confirm('Remove {{ $member->name }} from the team?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
@endsection
