@extends('layouts.admin')
@section('title','Edit Cohort')
@section('breadcrumb')
    <span class="topbar-breadcrumb-item"><a href="{{ route('admin.cohorts.index') }}">Cohorts</a></span>
    <span class="topbar-breadcrumb-sep">/</span>
    <span class="topbar-breadcrumb-item current">Edit</span>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit: {{ $cohort->name }}</h1>
        <p class="page-subtitle">Batch {{ $cohort->batch_number }} · {{ $cohort->applications_count }} applications</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('admin.applications.index', ['cohort_id' => $cohort->id]) }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-file-alt"></i> View Applications
        </a>
        <a href="{{ route('admin.cohorts.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<form method="POST" action="{{ route('admin.cohorts.update', $cohort) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
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
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $cohort->name) }}" required>
                            @error('name')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Batch Number <span class="required">*</span></label>
                            <input type="number" name="batch_number" class="form-control"
                                value="{{ old('batch_number', $cohort->batch_number) }}" min="1" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Max Startups <span class="required">*</span></label>
                            <input type="number" name="max_startups" class="form-control"
                                value="{{ old('max_startups', $cohort->max_startups) }}" min="1" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status <span class="required">*</span></label>
                            <select name="status" class="form-control" required>
                                @foreach(['upcoming'=>'Upcoming','open'=>'Open','closed'=>'Closed','active'=>'Active','completed'=>'Completed'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('status', $cohort->status) === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Application Start <span class="required">*</span></label>
                            <input type="date" name="application_start" class="form-control"
                                value="{{ old('application_start', $cohort->application_start->format('Y-m-d')) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Application End <span class="required">*</span></label>
                            <input type="date" name="application_end" class="form-control"
                                value="{{ old('application_end', $cohort->application_end->format('Y-m-d')) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Program Start</label>
                            <input type="date" name="program_start" class="form-control"
                                value="{{ old('program_start', $cohort->program_start?->format('Y-m-d')) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Program End</label>
                            <input type="date" name="program_end" class="form-control"
                                value="{{ old('program_end', $cohort->program_end?->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $cohort->description) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Focus Areas <span style="font-weight:400;color:var(--text-muted);">(comma-separated)</span></label>
                        <input type="text" name="focus_areas" class="form-control"
                            value="{{ old('focus_areas', is_array($cohort->focus_areas) ? implode(', ', $cohort->focus_areas) : '') }}"
                            placeholder="AgriTech, HealthTech, FinTech">
                    </div>
                </div>
            </div>

            {{-- Stats Panel --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <div class="admin-card-title">Cohort Statistics</div>
                    <a href="{{ route('admin.applications.index', ['cohort_id' => $cohort->id]) }}" class="btn btn-secondary btn-sm">View All</a>
                </div>
                <div class="admin-card-body">
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;text-align:center;">
                        @php
                            $appStats = [
                                ['label'=>'Total Applications','val'=>$cohort->applications_count,'color'=>'var(--text-dark)'],
                                ['label'=>'Approved','val'=>$cohort->applications()->where('status','approved')->count(),'color'=>'var(--success)'],
                                ['label'=>'Pending','val'=>$cohort->applications()->where('status','pending')->count(),'color'=>'var(--warning)'],
                            ];
                        @endphp
                        @foreach($appStats as $stat)
                        <div style="padding:16px;background:var(--light);border-radius:var(--radius-md);">
                            <div style="font-size:1.75rem;font-weight:800;color:{{ $stat['color'] }};">{{ $stat['val'] }}</div>
                            <div style="font-size:0.72rem;color:var(--text-muted);margin-top:2px;">{{ $stat['label'] }}</div>
                        </div>
                        @endforeach
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
                    @if($cohort->image)
                        <img src="{{ asset('storage/'.$cohort->image) }}" alt=""
                            style="width:100%;max-height:120px;object-fit:cover;border-radius:var(--radius-sm);margin-bottom:10px;">
                        <p style="font-size:0.75rem;color:var(--text-muted);margin-bottom:8px;">Upload new to replace</p>
                    @endif
                    <div class="image-upload-area" onclick="this.querySelector('input').click()">
                        <input type="file" name="image" accept="image/*" style="display:none;" data-preview="cohortImgPreview">
                        <div class="image-upload-icon"><i class="fas fa-image"></i></div>
                        <div class="image-upload-text">{{ $cohort->image ? 'Change image' : 'Upload image' }}</div>
                        <div class="image-upload-sub">JPG, PNG — Max 3MB</div>
                        <img id="cohortImgPreview" class="image-preview" style="display:none;">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;">
                <i class="fas fa-save"></i> Update Cohort
            </button>
        </div>
    </div>
</form>

<form method="POST" action="{{ route('admin.cohorts.destroy', $cohort) }}" style="margin-top:12px;"
    onsubmit="return confirm('Delete this cohort? All applications will also be deleted.')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger" style="width:100%;">
        <i class="fas fa-trash"></i> Delete Cohort
    </button>
</form>
@endsection
