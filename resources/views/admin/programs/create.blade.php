@extends('layouts.admin')
@section('title','Create Program')
@section('breadcrumb')
    <span class="topbar-breadcrumb-item"><a href="{{ route('admin.programs.index') }}">Programs</a></span>
    <span class="topbar-breadcrumb-sep">/</span>
    <span class="topbar-breadcrumb-item current">Create</span>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Create Program</h1>
    <a href="{{ route('admin.programs.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<form method="POST" action="{{ route('admin.programs.store') }}" enctype="multipart/form-data">
    @csrf
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
                            <input type="text" name="title"
                                class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title') }}"
                                placeholder="e.g. Core Incubation Program" required>
                            @error('title')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Font Awesome Icon</label>
                            <input type="text" name="icon" class="form-control"
                                value="{{ old('icon', 'fa-rocket') }}"
                                placeholder="e.g. fa-rocket, fa-lightbulb">
                            <div class="form-hint">
                                Use <a href="https://fontawesome.com/icons" target="_blank" style="color:var(--crimson);">Font Awesome</a> class names
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Duration</label>
                            <input type="text" name="duration" class="form-control"
                                value="{{ old('duration') }}" placeholder="e.g. 6 Months">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control"
                                value="{{ old('sort_order', 0) }}" min="0">
                            <div class="form-hint">Lower = shown first</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Short Description <span class="required">*</span></label>
                        <textarea name="short_description"
                            class="form-control @error('short_description') is-invalid @enderror"
                            rows="2" maxlength="500"
                            placeholder="Brief one-paragraph description for cards and listings..." required>{{ old('short_description') }}</textarea>
                        @error('short_description')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Full Description</label>
                        <textarea name="full_description" class="form-control" rows="5"
                            placeholder="Detailed description shown on the programs page...">{{ old('full_description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Eligibility Criteria</label>
                        <input type="text" name="eligibility" class="form-control"
                            value="{{ old('eligibility') }}"
                            placeholder="e.g. Students, graduates, and early-stage entrepreneurs">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Benefits / What Participants Get</label>
                        <textarea name="benefits" class="form-control" rows="6"
                            placeholder="Enter one benefit per line:&#10;Mentorship sessions&#10;Access to co-working space&#10;Seed funding opportunity">{{ old('benefits') }}</textarea>
                        <div class="form-hint">Enter one benefit per line — each will become a bullet point</div>
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
                    <div class="form-group">
                        <label class="form-toggle">
                            <div class="toggle-switch">
                                <input type="checkbox" name="is_active" value="1"
                                    {{ old('is_active', true) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </div>
                            <span class="toggle-label">Active (show on website)</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="admin-form-section" style="margin-bottom:16px;">
                <div class="admin-form-section-header">
                    <div class="admin-form-section-icon"><i class="fas fa-image"></i></div>
                    <div class="admin-form-section-title">Cover Image</div>
                </div>
                <div class="admin-form-section-body">
                    <div class="image-upload-area" onclick="this.querySelector('input').click()">
                        <input type="file" name="image" accept="image/*" style="display:none;" data-preview="programImgPreview">
                        <div class="image-upload-icon"><i class="fas fa-image"></i></div>
                        <div class="image-upload-text">Upload program image</div>
                        <div class="image-upload-sub">JPG, PNG — Max 3MB</div>
                        <img id="programImgPreview" class="image-preview" style="display:none;">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;">
                <i class="fas fa-save"></i> Create Program
            </button>
        </div>
    </div>
</form>
@endsection
