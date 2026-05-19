@extends('layouts.admin')
@section('title','Edit Program')
@section('breadcrumb')
    <span class="topbar-breadcrumb-item"><a href="{{ route('admin.programs.index') }}">Programs</a></span>
    <span class="topbar-breadcrumb-sep">/</span>
    <span class="topbar-breadcrumb-item current">Edit</span>
@endsection

@section('content')
<div class="page-header">
    <div><h1 class="page-title">Edit: {{ $program->title }}</h1></div>
    <a href="{{ route('admin.programs.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<form method="POST" action="{{ route('admin.programs.update', $program) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;">
        <div>
            <div class="admin-form-section">
                <div class="admin-form-section-header">
                    <div class="admin-form-section-icon"><i class="fas fa-graduation-cap"></i></div>
                    <div class="admin-form-section-title">Program Details</div>
                </div>
                <div class="admin-form-section-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Program Title <span class="required">*</span></label>
                            <input type="text" name="title" class="form-control"
                                value="{{ old('title', $program->title) }}" required>
                        </div>
                        <div class="form-group">
                            <x-admin.icon-picker name="icon" :value="old('icon', $program->icon ?? 'fa-rocket')" label="Icon" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Duration</label>
                            <input type="text" name="duration" class="form-control"
                                value="{{ old('duration', $program->duration) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control"
                                value="{{ old('sort_order', $program->sort_order) }}" min="0">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Short Description <span class="required">*</span></label>
                        <textarea name="short_description" class="form-control" rows="2" required>{{ old('short_description', $program->short_description) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Full Description</label>
                        <textarea name="full_description" class="form-control" rows="5">{{ old('full_description', $program->full_description) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Eligibility Criteria</label>
                        <input type="text" name="eligibility" class="form-control"
                            value="{{ old('eligibility', $program->eligibility) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Benefits (one per line)</label>
                        <textarea name="benefits" class="form-control" rows="6">{{ old('benefits', is_array($program->benefits) ? implode("\n", $program->benefits) : '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="admin-form-section" style="margin-bottom:16px;">
                <div class="admin-form-section-header">
                    <div class="admin-form-section-icon"><i class="fas fa-toggle-on"></i></div>
                    <div class="admin-form-section-title">Settings</div>
                </div>
                <div class="admin-form-section-body">
                    <label class="form-toggle">
                        <div class="toggle-switch">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active', $program->is_active) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </div>
                        <span class="toggle-label">Active</span>
                    </label>
                </div>
            </div>

            <div class="admin-form-section" style="margin-bottom:16px;">
                <div class="admin-form-section-header">
                    <div class="admin-form-section-icon"><i class="fas fa-image"></i></div>
                    <div class="admin-form-section-title">Image</div>
                </div>
                <div class="admin-form-section-body">
                    @if($program->image)
                        <img src="{{ asset('storage/'.$program->image) }}" alt=""
                            style="width:100%;max-height:120px;object-fit:cover;border-radius:var(--radius-sm);margin-bottom:10px;">
                        <p style="font-size:0.75rem;color:var(--text-muted);margin-bottom:8px;">Upload new to replace</p>
                    @endif
                    <div class="image-upload-area" onclick="this.querySelector('input').click()">
                        <input type="file" name="image" accept="image/*" style="display:none;" data-preview="imgPreview">
                        <div class="image-upload-icon"><i class="fas fa-image"></i></div>
                        <div class="image-upload-text">{{ $program->image ? 'Change image' : 'Upload image' }}</div>
                        <img id="imgPreview" class="image-preview" style="display:none;">
                    </div>
                </div>
            </div>

            <div style="display:flex;gap:10px;">
                <button type="submit" class="btn btn-primary" style="flex:1;">
                    <i class="fas fa-save"></i> Update
                </button>
                </form>
                <form method="POST" action="{{ route('admin.programs.destroy', $program) }}"
                    onsubmit="return confirm('Delete this program?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
@endsection
