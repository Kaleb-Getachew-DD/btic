@extends('layouts.admin')
@section('title', 'Edit Partner')
@section('breadcrumb')
    <span class="topbar-breadcrumb-item"><a href="{{ route('admin.partners.index') }}">Partners</a></span>
    <span class="topbar-breadcrumb-sep">/</span>
    <span class="topbar-breadcrumb-item current">Edit</span>
@endsection

@section('content')
<div class="page-header">
    <div><h1 class="page-title">Edit: {{ $partner->name }}</h1></div>
    <a href="{{ route('admin.partners.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<form method="POST" action="{{ route('admin.partners.update', $partner) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;">
        <div class="admin-form-section">
            <div class="admin-form-section-header">
                <div class="admin-form-section-icon"><i class="fas fa-handshake"></i></div>
                <div class="admin-form-section-title">Partner Details</div>
            </div>
            <div class="admin-form-section-body">
                <div class="form-group">
                    <label class="form-label">Partner Name <span class="required">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $partner->name) }}" required>
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $partner->description) }}</textarea>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Website URL</label>
                        <input type="url" name="website_url" class="form-control" value="{{ old('website_url', $partner->website_url) }}" placeholder="https://...">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $partner->sort_order) }}" min="0">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-toggle">
                        <div class="toggle-switch">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $partner->is_active) ? 'checked' : '' }}>
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
                    <div class="admin-form-section-title">Logo</div>
                </div>
                <div class="admin-form-section-body">
                    @if($partner->logo)
                        <img src="{{ asset('storage/'.$partner->logo) }}" alt="" style="width:100px;height:100px;border-radius:50%;object-fit:cover;margin-bottom:12px;display:block;">
                    @endif
                    <div class="image-upload-area" onclick="this.querySelector('input').click()">
                        <input type="file" name="logo" accept="image/*" style="display:none;" data-preview="logoPreview">
                        <div class="image-upload-icon"><i class="fas fa-building"></i></div>
                        <div class="image-upload-text">Upload new logo</div>
                        <div class="image-upload-sub">Leave empty to keep current</div>
                        <img id="logoPreview" class="image-preview" style="display:none;border-radius:50%;width:100px;height:100px;object-fit:cover;margin:10px auto 0;">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;"><i class="fas fa-save"></i> Save Changes</button>
        </div>
    </div>
</form>
@endsection
