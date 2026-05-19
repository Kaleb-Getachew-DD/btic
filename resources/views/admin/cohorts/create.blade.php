{{-- FILE: resources/views/admin/cohorts/create.blade.php --}}
@extends('layouts.admin')
@section('title', 'Create Cohort')
@section('breadcrumb')
    <span class="topbar-breadcrumb-item"><a href="{{ route('admin.cohorts.index') }}">Cohorts</a></span>
    <span class="topbar-breadcrumb-sep">/</span>
    <span class="topbar-breadcrumb-item current">Create</span>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Create New Cohort</h1>
    <a href="{{ route('admin.cohorts.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<form method="POST" action="{{ route('admin.cohorts.store') }}" enctype="multipart/form-data">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;">
        <div>
            <div class="admin-form-section">
                <div class="admin-form-section-header">
                    <div class="admin-form-section-icon"><i class="fas fa-layer-group"></i></div>
                    <div class="admin-form-section-title">Cohort Details</div>
                </div>
                <div class="admin-form-section-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Cohort Name <span class="required">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g. BTIC Cohort 7" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Batch Number <span class="required">*</span></label>
                            <input type="number" name="batch_number" class="form-control" value="{{ old('batch_number') }}" min="1" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Max Startups <span class="required">*</span></label>
                            <input type="number" name="max_startups" class="form-control" value="{{ old('max_startups', 20) }}" min="1" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status <span class="required">*</span></label>
                            <select name="status" class="form-control" required>
                                @foreach(['upcoming'=>'Upcoming','open'=>'Open (Accepting Applications)','closed'=>'Closed','active'=>'Active (In Progress)','completed'=>'Completed'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('status', 'upcoming') === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Application Start <span class="required">*</span></label>
                            <input type="date" name="application_start" class="form-control" value="{{ old('application_start') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Application End <span class="required">*</span></label>
                            <input type="date" name="application_end" class="form-control" value="{{ old('application_end') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Program Start</label>
                            <input type="date" name="program_start" class="form-control" value="{{ old('program_start') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Program End</label>
                            <input type="date" name="program_end" class="form-control" value="{{ old('program_end') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Describe this cohort's focus and goals...">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Focus Areas</label>
                        <input type="text" name="focus_areas" class="form-control" value="{{ old('focus_areas') }}" placeholder="AgriTech, HealthTech, FinTech">
                        <div class="form-hint">Comma-separated list of focus sectors</div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="admin-form-section" style="margin-bottom:16px;">
                <div class="admin-form-section-header">
                    <div class="admin-form-section-icon"><i class="fas fa-image"></i></div>
                    <div class="admin-form-section-title">Cover Image</div>
                </div>
                <div class="admin-form-section-body">
                    <div class="image-upload-area" onclick="this.querySelector('input').click()">
                        <input type="file" name="image" accept="image/*" style="display:none;">
                        <div class="image-upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                        <div class="image-upload-text">Upload cohort image</div>
                        <div class="image-upload-sub">JPG, PNG — Max 3MB</div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;"><i class="fas fa-save"></i> Create Cohort</button>
        </div>
    </div>
</form>
@endsection
